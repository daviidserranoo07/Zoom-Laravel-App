<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Reunión</title>
</head>
<body>
    <h1>Crear Reunión</h1>
    <form action="{{ route('zoom.createMeetingStore') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="topic">Tema de la reunión:</label>
        <input type="text" id="topic" name="topic" required>

        <label for="start_time">Fecha y hora de inicio:</label>
        <input type="datetime-local" id="start_time" name="start_time" required>

        <label for="duration">Duración (en minutos):</label>
        <input type="number" id="duration" name="duration" required min="1">

        <label for="agenda">Agenda:</label>
        <textarea id="agenda" name="agenda" rows="4" required></textarea>

        <!-- Campo oculto para tipo de reunión -->
        <input type="hidden" name="type" value="2">

        <!-- Campo oculto para la zona horaria -->
        <input type="hidden" name="timezone" value="Europe/Madrid">

        <input type="submit" value="Crear Reunión">
    </form>
</body>
</html>
