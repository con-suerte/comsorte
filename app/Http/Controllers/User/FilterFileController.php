<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class FilterFileController extends Controller
{
    public function download(Campaign $campaign)
    {
        $this->authorizeCampaign($campaign);

        // Generar el contenido del filter.php on the fly.
        // Luego ofuscarlo.
        
        $content = $this->generateFilterFileContent($campaign);
        $obfuscated = $this->obfuscate($content);

        return new Response($obfuscated, 200, [
            'Content-Type' => 'application/php',
            'Content-Disposition' => 'attachment; filename="filter.php"'
        ]);
    }

    protected function generateFilterFileContent(Campaign $campaign)
    {
        // Plantilla base: consultar la API del servidor central.
        // Supongamos que tenemos una URL de API: config('app.url').'/api/filter-check'
        
        $token = $campaign->token;
        $apiUrl = config('app.url').'/api/filter-check';

        $template = <<<'PHP'
<?php
// Filter file generated
$token = '__TOKEN__';
$apiUrl = '__APIURL__';

$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
$queryString = $_SERVER['QUERY_STRING'] ?? '';
$referrer = $_SERVER['HTTP_REFERER'] ?? '';

$data = [
    'token' => $token,
    'ip' => $ip,
    'ua' => $ua,
    'query' => $queryString,
    'referrer' => $referrer
];

// Llamar a la API
$response = @file_get_contents($apiUrl.'?'.http_build_query($data));

if($response === false) {
    // Si falla la API, mostrar safe_page o no action
    // Por simplicidad, no redirigimos. Podríamos fallback a una safe page estática.
    // Aquí solo devolvemos algo neutro:
    echo "Error al conectar con el servidor. Intente más tarde.";
    exit;
}

$result = json_decode($response, true);

if(isset($result['action'])) {
    switch($result['action']) {
        case 'redirect':
            header("Location: ".$result['url']);
            exit;
        case 'display_html':
            echo $result['html'];
            exit;
        // Otros casos: iframe, no_action, etc.
        default:
            echo "Acción no definida.";
    }
} else {
    // Si no se recibe acción, no hacemos nada
    echo "Sin acción definida.";
}
PHP;

        $template = str_replace('__TOKEN__', $token, $template);
        $template = str_replace('__APIURL__', $apiUrl, $template);

        return $template;
    }

    protected function obfuscate($content)
    {
        // Técnica simple de ofuscación: base64 + eval
        // En un entorno real, usaríamos una librería de ofuscación más compleja.
        
        $encoded = base64_encode($content);
        $obfuscated = "<?php eval(base64_decode('".$encoded."'));";
        return $obfuscated;
    }

    protected function authorizeCampaign(Campaign $campaign)
    {
        if ($campaign->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
