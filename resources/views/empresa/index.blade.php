@extends('layouts.app')

@section('title', 'Dashboard - Empresas Cadastradas')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        @if($empresas->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-sm font-medium text-gray-500">Total de Empresas</div>
                    <div class="text-3xl font-bold text-blue-600">{{ $empresas->count() }}</div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-sm font-medium text-gray-500">Total ICMS Pago</div>
                    <div class="text-2xl font-bold text-gray-800">R$ {{ number_format($empresas->sum('icms_pago'), 2, ',', '.') }}</div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-sm font-medium text-gray-500">Total Créditos Possíveis</div>
                    <div class="text-2xl font-bold text-green-600">R$ {{ number_format($empresas->sum('credito_possivel'), 2, ',', '.') }}</div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-sm font-medium text-gray-500">Percentual Médio</div>
                    <div class="text-3xl font-bold text-purple-600">
                        {{ $empresas->avg('percentual_credito') ? number_format($empresas->avg('percentual_credito'), 1, ',', '.') : '0' }}%
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Créditos por Empresa</h3>
                    <canvas id="creditosChart" height="200"></canvas>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribuição de Percentuais</h3>
                    <canvas id="percentualChart" height="200"></canvas>
                </div>
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-800 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold">Empresas Cadastradas</h2>
                <a href="{{ route('empresa.create') }}" 
                   class="bg-white text-blue-800 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition">
                    + Nova Empresa
                </a>
            </div>

            <div class="p-6">
                @if($empresas->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <p class="mt-4 text-gray-500 text-lg">Nenhuma empresa cadastrada ainda.</p>
                        <a href="{{ route('empresa.create') }}" 
                           class="inline-block mt-4 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                            Cadastrar primeira empresa
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CNPJ</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ICMS Pago</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Crédito Possível</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Percentual</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($empresas as $empresa)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                            {{ $empresa->nome }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                            {{ $empresa->cnpj_formatado }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-gray-900">
                                            {{ $empresa->icms_pago_formatado }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-green-600 font-medium">
                                            {{ $empresa->credito_possivel_formatado }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $empresa->percentual_credito >= 20 ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ number_format($empresa->percentual_credito, 1, ',', '.') }}%
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                            <a href="{{ route('empresa.relatorio', $empresa->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 font-medium">
                                                Ver Relatório
                                            </a>
                                            <a href="{{ route('empresa.pdf', $empresa->id) }}" 
                                               class="text-green-600 hover:text-green-900 font-medium">
                                                PDF
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
    </div>
@endsection

@section('scripts')
@if($empresas->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const empresas = @json($empresas);
        
        // Aguarda o Vite carregar o app.js
        if (typeof window.initCharts === 'function') {
            window.initCharts(empresas);
        } else {
            // Fallback: espera o script carregar
            window.addEventListener('load', function() {
                if (typeof window.initCharts === 'function') {
                    window.initCharts(empresas);
                }
            });
        }
    });
</script>
@endif
@endsection