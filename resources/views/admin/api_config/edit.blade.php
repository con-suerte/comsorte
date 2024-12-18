@extends('layouts.admin')

@section('title', 'Configurar APIs Externas')

@section('admin-content')
<h1>APIs Externas</h1>
<form action="{{ route('admin.api_config.update') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>IP API Key:</label>
        <input type="text" name="ip_api_key" class="form-control" value="{{ $configs['IP_API_KEY'] ?? '' }}">
    </div>
    <div class="mb-3">
        <label>GeoIP API Key:</label>
        <input type="text" name="geoip_api_key" class="form-control" value="{{ $configs['GEOIP_API_KEY'] ?? '' }}">
    </div>
    <button class="btn btn-success" type="submit">Guardar</button>
</form>
@endsection
