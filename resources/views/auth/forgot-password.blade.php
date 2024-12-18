<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Olvidé mi contraseña</title>
</head>
<body>
    <h1>Recuperar Contraseña</h1>
    @if(session('status'))
        <p style="color:green;">{{ session('status') }}</p>
    @endif
    @if($errors->any())
        <div style="color:red;">
            @foreach($errors->all() as $error)
                <p>{{$error}}</p>
            @endforeach
        </div>
    @endif
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        
        <button type="submit">Enviar enlace de restablecimiento</button>
    </form>
</body>
</html>
