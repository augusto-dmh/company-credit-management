<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório - {{ $empresa->nome }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 40px;
        }
        h1 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .info {
            margin: 20px 0;
        }
        .info p {
            margin: 10px 0;
            font-size: 14px;
        }
        .info strong {
            display: inline-block;
            width: 180px;
        }
        .highlight {
            background-color: #f0f0f0;
            padding: 15px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 50px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Relatório de Créditos Tributários</h1>

    <div class="info">
        <p><strong>Empresa:</strong> {{ $empresa->nome }}</p>
        <p><strong>CNPJ:</strong> {{ $empresa->cnpj }}</p>
        <p><strong>ICMS Pago:</strong> {{ $empresa->icms_pago_formatado }}</p>
        <p><strong>Crédito Possível:</strong> {{ $empresa->credito_possivel_formatado }}</p>
    </div>

    <div class="highlight">
        <p><strong>Percentual de Crédito:</strong> {{ $empresa->percentual_credito }}%</p>
    </div>

    <div class="footer">
        <p>Relatório gerado em {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Sistema de Gestão de Créditos Tributários</p>
    </div>
</body>
</html>