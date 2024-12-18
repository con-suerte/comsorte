@extends('layouts.admin')

@section('title', 'Usuarios')

@section('admin-content')
<h1>Usuarios</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Activo</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($users as $u)
        <tr>
            <td>{{ $u->id }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ $u->roles->pluck('name')->join(', ') }}</td>
            <td>{{ $u->is_active ? 'Sí' : 'No' }}</td>
            <td>
                @if($u->is_active && !$u->hasRole('admin'))
                    <a href="{{ route('admin.users.suspend',$u) }}" class="btn btn-sm btn-danger">Suspender</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $users->links() }}
@endsection
