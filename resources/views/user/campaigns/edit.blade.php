@extends('layouts.user')

@section('title','Editar Campaña')

@section('user-content')
<h1>Editar Campaña: {{ $campaign->name }}</h1>
@if($errors->any())
<div class="alert alert-danger">
@foreach($errors->all() as $error)
    <div>{{ $error }}</div>
@endforeach
</div>
@endif

<form action="{{ route('user.campaigns.update',$campaign) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nombre:</label>
        <input type="text" name="name" class="form-control" value="{{ old('name',$campaign->name) }}" required>
    </div>
    <div class="mb-3">
        <label>Money Page URL:</label>
        <input type="url" name="money_page_url" class="form-control" value="{{ old('money_page_url',$campaign->money_page_url) }}" required>
    </div>
    <div class="mb-3">
        <label>Money Page Action:</label>
        <select name="money_page_action" class="form-control">
            @php
                $mpa = old('money_page_action',$campaign->money_page_action)
            @endphp
            <option value="no_action" @if($mpa=='no_action') selected @endif>No Action</option>
            <option value="redirect" @if($mpa=='redirect') selected @endif>Redirect</option>
            <option value="display_html" @if($mpa=='display_html') selected @endif>Display HTML</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Safe Page URL:</label>
        <input type="url" name="safe_page_url" class="form-control" value="{{ old('safe_page_url',$campaign->safe_page_url) }}">
    </div>
    <div class="mb-3">
        <label>Safe Page Action:</label>
        @php
            $spa = old('safe_page_action',$campaign->safe_page_action)
        @endphp
        <select name="safe_page_action" class="form-control">
            <option value="no_action" @if($spa=='no_action') selected @endif>No Action</option>
            <option value="redirect" @if($spa=='redirect') selected @endif>Redirect</option>
            <option value="display_html" @if($spa=='display_html') selected @endif>Display HTML</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Filter Level:</label>
        @php
            $fl = old('filter_level',$campaign->filter_level)
        @endphp
        <select name="filter_level" class="form-control">
            <option value="off" @if($fl=='off') selected @endif>Off</option>
            <option value="low" @if($fl=='low') selected @endif>Low</option>
            <option value="medium" @if($fl=='medium') selected @endif>Medium</option>
            <option value="high" @if($fl=='high') selected @endif>High</option>
            <option value="paranoid" @if($fl=='paranoid') selected @endif>Paranoid</option>
        </select>
    </div>

    <!-- Aquí podríamos agregar campos para allowed_countries, etc., usando inputs dinámicos -->

    <button class="btn btn-primary" type="submit">Guardar</button>
</form>
@endsection
