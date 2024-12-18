@extends('layouts.user')

@section('title','Mis Campañas')

@section('user-content')
<h1>Mis Campañas</h1>
<a href="{{ route('user.campaigns.create') }}" class="btn btn-primary mb-3">Crear Nueva Campaña</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nombre</th><th>Token</th><th>Modo</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($campaigns as $c)
        <tr>
            <td>{{ $c->name }}</td>
            <td>{{ $c->token }}</td>
            <td>{{ $c->mode }}</td>
            <td>
                <a href="{{ route('user.campaigns.edit',$c) }}" class="btn btn-sm btn-warning">Editar</a>
                <a href="{{ route('user.campaigns.filterfile',$c) }}" class="btn btn-sm btn-info">Descargar filter.php</a>
                <a href="{{ route('user.campaigns.stats',$c) }}" class="btn btn-sm btn-secondary">Estadísticas</a>
                <form action="{{ route('user.campaigns.destroy',$c) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $campaigns->links() }}
@endsection
