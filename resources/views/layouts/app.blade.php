<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Projeto UPX') }}</title>

    {{-- Estilo via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.ts'])

    {{-- Fontes e Ícones opcionais --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
</head>
<body style="background-color: #f3f4f6; font-family: 'Inter', sans-serif;">

{{-- Cabeçalho opcional --}}
<header style="padding: 20px; background-color: #8B0000; color: white;">
    <h1 style="margin: 0; text-align: center" >Sistema de Cadastro de peças para a Bosch</h1>
</header>

{{-- Conteúdo dinâmico --}}
<main>
    @yield('content')
</main>

<p class="mensagem-informativa">
    Após a requisição da peça ser protocolada, você receberá um e-mail com o resultado e a situação atual da sua solicitação.
</p>

{{-- Rodapé opcional --}}
<footer style="padding: 20px; text-align: center; color: #555;">
    &copy; {{ date('Y') }} - Todos os direitos reservados.
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const brandInput = document.getElementById('brand');
        const curNoInput = document.getElementById('cur_no');
        const bkInput = document.getElementById('bk');
        const ownerBkInput = document.getElementById('owner_bk');

        function updateBkAndOwner() {
            const brand = brandInput.value.trim();
            const curNo = curNoInput.value.trim();

            if (brand && curNo) {
                bkInput.value = brand + curNo;
                ownerBkInput.value = 'SA';
            } else {
                bkInput.value = '';
                ownerBkInput.value = '';
            }
        }

        brandInput.addEventListener('input', updateBkAndOwner);
        curNoInput.addEventListener('input', updateBkAndOwner);
    });
</script>
</body>
</html>
