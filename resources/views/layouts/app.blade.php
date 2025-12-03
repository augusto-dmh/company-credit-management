<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestão de Créditos Tributários')</title>
</head>
<body>
    <header>
        <h1>Sistema de Gestão de Créditos Tributários</h1>
        <nav>
            <a href="{{ route('empresa.create') }}">Cadastrar Empresa</a> |
            <a href="{{ route('empresa.index') }}">Listar Empresas</a>
        </nav>
        <hr>
    </header>

    <main>
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        @yield('content')
    </main>

    <footer>
        <hr>
        <p>&copy; {{ date('Y') }} - Auditoria Tributária</p>
    </footer>
</body>
</html>