<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Llamado de emergencia</title>
</head>
<body>
    <p>Hola! {{$user->name . $user->lastname}}.</p>
    <p>Cambiaste tu correo electrónico. Por favor verificala usando el siguiente enlace.</p>
    <ul>
    <li>{{route('verify',$user->verification_token)}}</li>
        
    </ul>
    <p>Att. Soporte </p>
</body>
</html>