@extends('layouts.app')

@section('title', 'Dashboard - Empresas Cadastradas')

@section('content')
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-800 text-white px-6 py-4 flex justify-between items-center">
            <h2 class="text-2xl font-bold">Dashboard - Empresas Cadastradas</h2>
            <a href="{{ route('empresa.create') }}" 
               class="bg-white text-blue-800 px-4 py-2 rounded-lg hover:bg-blue-50 transition font-medium">
                + Nova Empresa
            </a>
        </div>

        <div class="p-6">
            @if($empresas->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg mb-4">Nenhuma empresa cadastrada ainda.</p>
                    <a href="{{ route('empresa.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Cadastrar primeira empresa
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Nome</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">CNPJ</th>
                                <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">ICMS Pago</th>
                                <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Crédito Possível</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Percentual</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($empresas as $empresa)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $empresa->nome }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $empresa->cnpj }}</td>
                                    <td class="px-4 py-3 text-right text-gray-600">{{ $empresa->icms_pago_formatado }}</td>
                                    <td class="px-4 py-3 text-right text-green-600 font-medium">{{ $empresa->credito_possivel_formatado }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            {{ $empresa->percentual_credito >= 20 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $empresa->percentual_credito }}%
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('empresa.relatorio', $empresa->id) }}" class="text-blue-600 hover:underline">
                                            Ver Relatório
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection