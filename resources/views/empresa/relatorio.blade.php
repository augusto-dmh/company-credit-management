@extends('layouts.app')

@section('title', 'Relatório - ' . $empresa->nome)

@section('content')
    <h2>Relatório de Créditos Tributários</h2>

    <div>
        <p><strong>Empresa:</strong> {{ $empresa->nome }}</p>
        <p><strong>CNPJ:</strong> {{ $empresa->cnpj }}</p>
        <p><strong>ICMS Pago:</strong> {{ $empresa->icms_pago_formatado }}</p>
        <p><strong>Crédito Possível:</strong> {{ $empresa->credito_possivel_formatado }}</p>
        <p><strong>Percentual de Crédito:</strong> {{ $empresa->percentual_credito }}%</p>
    </div>

    <br>

    <a href="{{ route('empresa.create') }}">Cadastrar Nova Empresa</a> |
    <a href="{{ route('empresa.index') }}">Ver Todas as Empresas</a>
@endsection