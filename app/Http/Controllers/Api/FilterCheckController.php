<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use Carbon\Carbon;
use App\Models\ExternalApiConfig;

class FilterCheckController extends Controller
{
    public function check(Request $request)
    {
        // Parámetros esperados: token, ip, ua, query, referrer
        $token = $request->get('token');
        $ip = $request->get('ip', '');
        $ua = $request->get('ua', '');
        $referrer = $request->get('referrer', '');
        $queryString = $request->get('query', '');

        // Buscar campaña
        $campaign = Campaign::where('token', $token)->with('filters','user.subscription')->first();
        if (!$campaign || !$campaign->active) {
            return $this->safeResponse("Campaña no encontrada o inactiva.");
        }

        // Verificar suscripción del usuario (si expiró, modo all_safe)
        $this->checkSubscription($campaign);

        // Si modo all_safe
        if ($campaign->mode === 'all_safe') {
            return $this->performAction($campaign->safe_page_action, $campaign->safe_page_url, "Modo all_safe aplicado.");
        }

        // Si modo all_money
        if ($campaign->mode === 'all_money') {
            return $this->performAction($campaign->money_page_action, $campaign->money_page_url, "Modo all_money aplicado.");
        }

        // Si modo on_review: podríamos aplicar reglas especiales, por ahora asumimos que es similar a filtering.
        // Modo filtering: aplicar todas las reglas

        $filter = $campaign->filters;

        // Parsear UTM del query string (si las necesitamos)
        $utmSource = null;
        $utmMedium = null;
        parse_str($queryString, $params);
        if (isset($params['utm_source'])) $utmSource = $params['utm_source'];
        if (isset($params['utm_medium'])) $utmMedium = $params['utm_medium'];

        // Aplicar filtrados:
        // 1. Verificar geolocalización (IP -> País) si se requiere
        $country = $this->getCountryFromIP($ip);
        if (!empty($filter->allowed_countries) && !in_array($country, $filter->allowed_countries)) {
            return $this->safeResponse("País no permitido ($country).");
        }

        // 2. Verificar SO, navegador del UA (asumimos tenemos métodos para detectar)
        $browser = $this->detectBrowser($ua);
        $os = $this->detectOS($ua);

        if (!empty($filter->allowed_os) && !in_array($os, $filter->allowed_os)) {
            return $this->safeResponse("SO no permitido ($os).");
        }

        if (!empty($filter->allowed_browsers) && !in_array($browser, $filter->allowed_browsers)) {
            return $this->safeResponse("Navegador no permitido ($browser).");
        }

        // 3. Verificar IP bloqueada
        if (!empty($filter->blocked_ips) && in_array($ip, $filter->blocked_ips)) {
            return $this->safeResponse("IP bloqueada ($ip).");
        }

        // 4. Verificar required_utm
        if (!empty($filter->required_utm)) {
            foreach ($filter->required_utm as $key => $value) {
                if (!isset($params[$key]) || strtolower($params[$key]) !== strtolower($value)) {
                    return $this->safeResponse("UTM requerida no presente o no coincide ($key=$value).");
                }
            }
        }

        // 5. Filtrar por timezone / dayparting si fuera el caso
        // Supondremos no tenemos timezone del navegador fácilmente aquí, a menos que se pase por JS.
        // Por simplicidad, omitimos esta parte. Podríamos integrar una lógica adicional si tuviéramos más datos.

        // 6. Filter level (off, low, medium, high, paranoid)
        // Dependiendo del nivel, podríamos consultar APIs externas para IP reputation
        // Por ejemplo, en level high o paranoid, consultamos IP reputation
        if (in_array($campaign->filter_level, ['high','paranoid'])) {
            if ($this->isSuspiciousIP($ip)) {
                return $this->safeResponse("IP sospechosa según reputación externa.");
            }
        }

        // Si llegamos hasta aquí, es un visitante "válido"
        return $this->performAction($campaign->money_page_action, $campaign->money_page_url, "Visitante válido.");

    }

    protected function safeResponse($reason = '')
    {
        // Devolver acción para safe page (ejemplo: si no se definió safe_page_action, no_action)
        return response()->json([
            'action' => 'redirect', // Podríamos decidir mostrar no_action si safe_page_url no está
            'url' => 'about:blank', // Podríamos usar la URL de safe_page global del campaign si la tuviéramos
            'reason' => $reason
        ]);
    }

    protected function performAction($action, $url, $reason = '')
    {
        // Dependiendo de la acción, devolvemos el JSON apropiado
        switch($action) {
            case 'redirect':
                return response()->json(['action' => 'redirect', 'url' => $url, 'reason'=>$reason]);
            case 'display_html':
                // Podríamos obtener el HTML de la URL si es local, por simplicidad asumimos que $url es el HTML directamente (o podríamos cargarlo)
                return response()->json(['action' => 'display_html', 'html' => '<h1>Página Mostrar</h1>', 'reason'=>$reason]);
            case 'no_action':
            default:
                return response()->json(['action' => 'no_action', 'reason'=>$reason]);
        }
    }

    protected function checkSubscription($campaign)
    {
        $subscription = $campaign->user->subscription;
        if (!$subscription || !$subscription->expires_at || Carbon::now()->greaterThan($subscription->expires_at)) {
            // Suscripción expirada: modo all_safe
            $campaign->mode = 'all_safe';
        }
    }

    protected function getCountryFromIP($ip)
    {
        // Implementar lookup con una API externa si tenemos la clave
        // Por simplicidad, devolvemos 'US'
        // En implementación real, usaríamos ExternalApiConfig para obtener el API key y hacer request a GeoIP API
        return 'US';
    }

    protected function detectBrowser($ua)
    {
        // Detección simplificada, en un entorno real usaríamos una librería como ua-parser
        if (stripos($ua,'chrome') !== false) return 'Chrome';
        if (stripos($ua,'firefox') !== false) return 'Firefox';
        if (stripos($ua,'safari') !== false) return 'Safari';
        return 'Other';
    }

    protected function detectOS($ua)
    {
        if (stripos($ua,'win') !== false) return 'Windows';
        if (stripos($ua,'mac') !== false) return 'macOS';
        if (stripos($ua,'linux') !== false) return 'Linux';
        return 'OtherOS';
    }

    protected function isSuspiciousIP($ip)
    {
        // Aquí consultaríamos una API externa con la llave guardada en ExternalApiConfig
        // Por simplicidad, devolvemos false (no sospechoso)
        return false;
    }
}
