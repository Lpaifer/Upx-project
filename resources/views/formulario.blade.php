@extends('layouts.app')

@section('content')
    @if(session('success'))
        <p class="success-message">{{ session('success') }}</p>
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
