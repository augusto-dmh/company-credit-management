@extends('layouts.app')

@section('title', 'Cadastrar Empresa')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Cadastrar Empresa</h2>

            <div id="form-messages"></div>

            <form id="empresa-form" action="{{ route('empresa.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">
                        Nome da Empresa
                    </label>
                    <input type="text" id="nome" name="nome" value="{{ old('nome') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('nome')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <span class="error-message text-red-500 text-sm" id="nome-error"></span>
                </div>

                <div>
                    <label for="cnpj" class="block text-sm font-medium text-gray-700 mb-1">
                        CNPJ
                    </label>
                    <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj') }}" 
                           placeholder="00.000.000/0000-00" maxlength="18"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                    @error('cnpj')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <span class="error-message text-red-500 text-sm" id="cnpj-error"></span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="icms_pago" class="block text-sm font-medium text-gray-700 mb-1">
                            Valor Total de ICMS Pago (R$)
                        </label>
                        <input type="number" id="icms_pago" name="icms_pago" 
                               value="{{ old('icms_pago') }}" step="0.01" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('icms_pago')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <span class="error-message text-red-500 text-sm" id="icms_pago-error"></span>
                    </div>

                    <div>
                        <label for="credito_possivel" class="block text-sm font-medium text-gray-700 mb-1">
                            Valor de Créditos Possíveis (R$)
                        </label>
                        <input type="number" id="credito_possivel" name="credito_possivel" 
                               value="{{ old('credito_possivel') }}" step="0.01" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                        @error('credito_possivel')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <span class="error-message text-red-500 text-sm" id="credito_possivel-error"></span>
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="use-ajax" checked 
                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="use-ajax" class="ml-2 text-sm text-gray-600">
                        Enviar sem recarregar página (AJAX)
                    </label>
                </div>

                <button type="submit" id="submit-btn"
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-200 font-medium">
                    Cadastrar Empresa
                </button>
            </form>
        </div>
    </div>

    <script>
        // CNPJ mask
        document.getElementById('cnpj').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 14) {
                value = value.slice(0, 14);
            }
            
            if (value.length > 12) {
                value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2}).*/, '$1.$2.$3/$4-$5');
            } else if (value.length > 8) {
                value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d*).*/, '$1.$2.$3/$4');
            } else if (value.length > 5) {
                value = value.replace(/^(\d{2})(\d{3})(\d*).*/, '$1.$2.$3');
            } else if (value.length > 2) {
                value = value.replace(/^(\d{2})(\d*).*/, '$1.$2');
            }
            
            e.target.value = value;
        });

        // Clear error messages on input
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                const errorSpan = document.getElementById(this.id + '-error');
                if (errorSpan) errorSpan.textContent = '';
            });
        });

        // AJAX form submission
        document.getElementById('empresa-form').addEventListener('submit', function(e) {
            const useAjax = document.getElementById('use-ajax').checked;
            
            if (!useAjax) return;
            
            e.preventDefault();
            
            const form = e.target;
            const submitBtn = document.getElementById('submit-btn');
            const messagesDiv = document.getElementById('form-messages');
            
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            messagesDiv.innerHTML = '';
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Enviando...';
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            
            const formData = new FormData(form);
            
            fetch('/api/empresa', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': formData.get('_token'),
                },
                body: formData
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(({ status, body }) => {
                if (status === 201) {
                    messagesDiv.innerHTML = '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">' + body.message + '</div>';
                    window.location.href = body.redirect_url;
                } else if (status === 422) {
                    Object.keys(body.errors || {}).forEach(field => {
                        const errorSpan = document.getElementById(field + '-error');
                        if (errorSpan) {
                            errorSpan.textContent = body.errors[field][0];
                        }
                    });
                } else {
                    messagesDiv.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Erro ao cadastrar empresa.</div>';
                }
            })
            .catch(error => {
                messagesDiv.innerHTML = '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">Erro de conexão.</div>';
                console.error('Error:', error);
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Cadastrar Empresa';
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            });
        });
    </script>
@endsection