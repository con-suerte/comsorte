<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
</head>
<body>
    <h1>Restablecer Contraseña</h1>
    @if($errors->any())
        <div style="color:red;">
            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        </div>
    @endif
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        
        <label>Email:</label>
        <input type="email" name="email" required value="{{ old('email') }}"><br><br>
        
        <label>Nueva Contraseña:</label>
        <input type="password" name="password" required><br><br>

        <label>Confirmar Contraseña:</label>
        <input type="password" name="password_confirmation" required><br><br>
        
        <button type="submit">Restablecer</button>
    </form>
</body>
</html>
