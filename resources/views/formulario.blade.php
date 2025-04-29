<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Formulário</title>
</head>
<body>
@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<form action="{{ route('formulario.store') }}" method="POST">
    @csrf
    <label>Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Mensagem:</label><br>
    <textarea name="mensagem" required></textarea><br><br>

    <button type="submit">Enviar</button>
</form>
</body>
</html>
