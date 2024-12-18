@extends('layouts.user')

@section('title','Crear Campaña')

@section('user-content')
<h1>Crear Campaña</h1>
@if($errors->any())
<div class="alert alert-danger">
@foreach($errors->all() as $error)
    <div>{{ $error }}</div>
@endforeach
</div>
@endif

<form action="{{ route('user.campaigns.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nombre:</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Money Page URL:</label>
        <input type="url" name="money_page_url" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Money Page Action:</label>
        <select name="money_page_action" class="form-control">
            <option value="no_action">No Action</option>
            <option value="redirect">Redirect</option>
            <option value="display_html">Display HTML</option>
            <!-- Podríamos añadir más acciones -->
        </select>
    </div>
    <div class="mb-3">
        <label>Safe Page URL:</label>
        <input type="url" name="safe_page_url" class="form-control">
    </div>
    <div class="mb-3">
        <label>Safe Page Action:</label>
        <select name="safe_page_action" class="form-control">
            <option value="no_action">No Action</option>
            <option value="redirect">Redirect</option>
            <option value="display_html">Display HTML</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Filter Level:</label>
        <select name="filter_level" class="form-control">
            <option value="off">Off</option>
            <option value="low">Low</option>
            <option value="medium" selected>Medium</option>
            <option value="high">High</option>
            <option value="paranoid">Paranoid</option>
        </select>
    </div>
    <button class="btn btn-success" type="submit">Crear</button>
</form>
@endsection
