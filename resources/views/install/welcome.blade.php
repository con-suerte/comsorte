<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instalación - Bienvenido</title>
</head>
<body>
    <h1>Bienvenido al Instalador</h1>
    <p>Este asistente le ayudará a configurar el sistema.</p>
    <form action="{{ route('install.checkRequirements') }}" method="POST">
        @csrf
        <button type="submit">Comenzar</button>
    </form>
</body>
</html>
