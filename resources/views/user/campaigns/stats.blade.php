@extends('layouts.user')

@section('title', 'Estadísticas de la Campaña')

@section('user-content')
<h1>Estadísticas para: {{ $campaign->name }}</h1>
<p>Visitas totales: {{ $logsCount }}</p>
<p>Visitas filtradas (safe): {{ $filteredCount }}</p>
<!-- Aquí podríamos agregar gráficos (con Chart.js) -->
@endsection
