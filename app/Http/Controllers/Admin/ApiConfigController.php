<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExternalApiConfig;
use Illuminate\Http\Request;

class ApiConfigController extends Controller
{
    public function edit()
    {
        // Obtener las configuraciones existentes
        $configs = ExternalApiConfig::all()->pluck('key_value','key_name');
        return view('admin.api_config.edit', compact('configs'));
    }

    public function update(Request $request)
    {
        // Esperamos recibir campos como ip_api_key, geoip_api_key, etc.
        $data = $request->validate([
            'ip_api_key' => 'nullable|string',
            'geoip_api_key' => 'nullable|string'
        ]);

        $this->setConfig('IP_API_KEY', $data['ip_api_key'] ?? '');
        $this->setConfig('GEOIP_API_KEY', $data['geoip_api_key'] ?? '');

        return redirect()->route('admin.api_config.edit')->with('status','Configuraciones actualizadas.');
    }

    protected function setConfig($key, $value)
    {
        $config = ExternalApiConfig::firstOrNew(['key_name' => $key]);
        $config->key_value = $value;
        $config->save();
    }
}

