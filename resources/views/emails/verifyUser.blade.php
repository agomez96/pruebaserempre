<!DOCTYPE html>
<html>
<head>
    <title>Registro Exitoso</title>
</head>

<body>
<h2>Bienvenido {{$user['name']}}</h2>
<br/>
Tu correo registrado es {{$user['email']}} , Por favor dar click en el siguiente link para verificar tu correo
<br/>
<a href="{{url('user/verify', $user->verifyUser->token)}}">Verificar correo</a>
</body>

</html>