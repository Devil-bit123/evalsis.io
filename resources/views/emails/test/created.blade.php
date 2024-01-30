<!-- resources/views/emails/test/created.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Created Notification</title>
    <style>
        body {
            background-color: #00C793;
            color: #fff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #fff;
        }

        p {
            font-size: 18px;
            line-height: 1.5;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        p.signature {
            margin-top: 20px;
        }

        a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1 style="background-color: #006A5B; padding: 10px;">Se ha agregado un nuevo test!</h1>

    <p>
        Hola estudiantes,
    </p>

    <p>
        Se ha creado un nuevo test para el curso "{{ $test->course->name }}".
    </p>

    <p>
        Detalles del test:
    </p>

    <ul>
        <li style="background-color: #006A5B; padding: 5px; border-radius: 5px;">Fecha del test: {{ $test->date }}</li>
    </ul>

    <p>
        ¡Buena suerte!
    </p>

    <p class="signature">Saludos,<br>Equipo de EvalSis</p>
</body>
</html>
