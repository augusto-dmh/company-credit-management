@extends('layouts.app')

@section('title', 'Relatório - ' . $empresa->nome)

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-800 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">Relatório de Créditos Tributários</h2>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Empresa</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $empresa->nome }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">CNPJ</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $empresa->cnpj }}</p>
                    </div>
                </div>

                <hr class="border-gray-200">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">ICMS Pago</p>
                        <p class="text-xl font-bold text-gray-800">{{ $empresa->icms_pago_formatado }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Crédito Possível</p>
                        <p class="text-xl font-bold text-green-600">{{ $empresa->credito_possivel_formatado }}</p>
                    </div>
                </div>

                <div class="bg-blue-50 p-6 rounded-lg text-center">
                    <p class="text-sm text-blue-600 mb-1">Percentual de Crédito</p>
                    <p class="text-4xl font-bold text-blue-800">{{ $empresa->percentual_credito }}%</p>
                </div>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex flex-wrap gap-4 justify-center">
                <a href="{{ route('empresa.pdf', $empresa->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    📄 Baixar PDF
                </a>
                <a href="{{ route('empresa.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    + Nova Empresa
                </a>
                <a href="{{ route('empresa.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    📊 Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection