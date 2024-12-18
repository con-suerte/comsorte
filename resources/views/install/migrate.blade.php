<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Migrando la Base de Datos</title>
</head>
<body>
    <h1>Migrando...</h1>
    @if(isset($error))
        <p style="color:red;">Ha ocurrido un error al migrar: {{ $error }}</p>
        <p>Por favor, revise la configuración y reintente.</p>
    @else
        <p>La migración se ejecutó correctamente. Redirigiendo...</p>
        <script>
            setTimeout(() => {
                window.location.href = "{{ route('install.adminUserForm') }}";
            }, 2000);
        </script>
    @endif
</body>
</html>
