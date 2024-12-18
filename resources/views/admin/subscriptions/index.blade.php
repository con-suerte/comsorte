@extends('layouts.admin')

@section('title', 'Suscripciones')

@section('admin-content')
<h1>Suscripciones</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Usuario</th><th>Expira en</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($subscriptions as $sub)
        <tr>
            <td>{{ $sub->user->email }}</td>
            <td>{{ $sub->expires_at ?? 'No tiene suscripción activa' }}</td>
            <td>
                <form action="{{ route('admin.subscriptions.extend',$sub->user) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-primary" type="submit">Extender 30 días</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $subscriptions->links() }}
@endsection
