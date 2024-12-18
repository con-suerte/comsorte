@extends('layouts.base')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{ route('user.dashboard') }}">User Panel</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNav" aria-controls="userNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="userNav">
    <ul class="navbar-nav me-auto">
      <li class="nav-item"><a class="nav-link" href="{{ route('user.campaigns.index') }}">Campañas</a></li>
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
    @yield('user-content')
</div>
@endsection
