<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Novo Trabalho Disponível</title>
</head>
<body>
    <h1>Novo Trabalho de {{ $work->lesson->subject->description }}</h1>
    <a href="{{ route('works.show', ['work' => $work->id]) }}">Ver trabalho</a>
</body>
</html>
