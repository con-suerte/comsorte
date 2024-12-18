<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario Administrador</title>
</head>
<body>
    <h1>Crear Usuario Administrador</h1>
    @if($errors->any())
        <div style="color:red;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form action="{{ route('install.createAdminUser') }}" method="POST">
        @csrf
        <label>Nombre:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirmar Contraseña:</label><br>
        <input type="password" name="password_confirmation" required><br><br>

        <button type="submit">Crear Admin</button>
    </form>
</body>
</html>
