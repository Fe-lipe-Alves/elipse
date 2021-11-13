<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - Redefinir Senha</title>
</head>
<body>
    <h1>Para redefinir a senha acesse o link </h1>
    <a href="{{ route('reset_password.return').'?token='.$token }}">{{ route('reset_password.return').'?token='.$token }}</a>
</body>
</html>
