<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración de Base de Datos</title>
</head>
<body>
    <h1>Configuración de Base de Datos</h1>
    @if($errors->any())
        <div style="color:red;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form action="{{ route('install.saveDbConfig') }}" method="POST">
        @csrf
        <label>Host DB:</label><br>
        <input type="text" name="db_host" value="127.0.0.1"><br><br>

        <label>Puerto DB:</label><br>
        <input type="text" name="db_port" value="3306"><br><br>

        <label>Nombre DB:</label><br>
        <input type="text" name="db_database"><br><br>

        <label>Usuario DB:</label><br>
        <input type="text" name="db_username" value="root"><br><br>

        <label>Contraseña DB:</label><br>
        <input type="password" name="db_password"><br><br>

        <button type="submit">Guardar y Continuar</button>
    </form>
</body>
</html>
