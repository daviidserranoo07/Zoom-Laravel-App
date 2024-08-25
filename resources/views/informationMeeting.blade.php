<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información Reunión</title>
</head>
<body>
    <div>
        <h1>Nombre</h1>
        <p>{{ $topic }}</p>
    </div>

    <div>
        <h3>Host</h3>
        <p>{{ $host_email }}</p>
    </div>

    <div>
        <p>Duración</p>
        <p>{{ $duration }}</p>
    </div>

    <div>
        <p>Fecha y hora de inicio</p>
        <p>{{ $safeTime }}</p>
    </div>

    <div>
        <p>Enlace para empezar</p>
        <a href="{{$start_url}}">Enlace para empezar zoom</a>
    </div>

    <div>
        <p>Enlace para unirse</p>
        <a href="{{$join_url }}">Enlace para unirse a zoom</a>
    </div>

</body>
</html>