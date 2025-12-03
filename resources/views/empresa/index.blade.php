@extends('layouts.app')

@section('title', 'Dashboard - Empresas Cadastradas')

@section('content')
    <h2>Empresas Cadastradas</h2>

    @if($empresas->isEmpty())
        <p>Nenhuma empresa cadastrada ainda.</p>
        <a href="{{ route('empresa.create') }}">Cadastrar primeira empresa</a>
    @else
        <table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>ICMS Pago</th>
                    <th>Crédito Possível</th>
                    <th>Percentual</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empresas as $empresa)
                    <tr>
                        <td>{{ $empresa->nome }}</td>
                        <td>{{ $empresa->cnpj }}</td>
                        <td>{{ $empresa->icms_pago_formatado }}</td>
                        <td>{{ $empresa->credito_possivel_formatado }}</td>
                        <td>{{ $empresa->percentual_credito }}%</td>
                        <td>
                            <a href="{{ route('empresa.relatorio', $empresa->id) }}">Ver Relatório</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection