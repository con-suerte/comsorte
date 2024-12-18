@extends('layouts.base')

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Panel</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <div class="collapse navbar-collapse" id="adminNav">
    <ul class="navbar-nav me-auto">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.users.index') }}">Usuarios</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.subscriptions.index') }}">Suscripciones</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.api_config.edit') }}">APIs Externas</a>
      </li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="btn btn-link nav-link" type="submit" style="text-decoration:none;">Salir</button>
        </form>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-4">
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @yield('admin-content')
</div>
@endsection
