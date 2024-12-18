<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Requerimientos</title>
</head>
<body>
    <h1>Verificación de Requerimientos</h1>
    <ul>
        @foreach($requirements as $req => $result)
            <li>
                {{ $req }}: {!! $result ? '<span style="color:green">OK</span>' : '<span style="color:red">FALLO</span>' !!}
            </li>
        @endforeach
    </ul>
    <p>Por favor, corrija los requerimientos marcados en rojo e inténtelo de nuevo.</p>
</body>
</html>
