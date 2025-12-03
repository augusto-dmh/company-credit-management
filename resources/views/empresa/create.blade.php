@extends('layouts.app')

@section('title', 'Cadastrar Empresa')

@section('content')
    <h2>Cadastrar Empresa</h2>

    <div id="form-messages"></div>

    <form id="empresa-form" action="{{ route('empresa.store') }}" method="POST">
        @csrf

        <div>
            <label for="nome">Nome da Empresa:</label><br>
            <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required>
            @error('nome')
                <p style="color: red;">{{ $message }}</p>
            @enderror
            <span class="error-message" id="nome-error" style="color: red;"></span>
        </div>

        <br>

        <div>
            <label for="cnpj">CNPJ:</label><br>
            <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj') }}" 
                   placeholder="00.000.000/0000-00" maxlength="18" required>
            @error('cnpj')
                <p style="color: red;">{{ $message }}</p>
            @enderror
            <span class="error-message" id="cnpj-error" style="color: red;"></span>
        </div>

        <br>

        <div>
            <label for="icms_pago">Valor Total de ICMS Pago (R$):</label><br>
            <input type="number" id="icms_pago" name="icms_pago" 
                   value="{{ old('icms_pago') }}" step="0.01" min="0" required>
            @error('icms_pago')
                <p style="color: red;">{{ $message }}</p>
            @enderror
            <span class="error-message" id="icms_pago-error" style="color: red;"></span>
        </div>

        <br>

        <div>
            <label for="credito_possivel">Valor de Créditos Possíveis (R$):</label><br>
            <input type="number" id="credito_possivel" name="credito_possivel" 
                   value="{{ old('credito_possivel') }}" step="0.01" min="0" required>
            @error('credito_possivel')
                <p style="color: red;">{{ $message }}</p>
            @enderror
            <span class="error-message" id="credito_possivel-error" style="color: red;"></span>
        </div>

        <br>

        <div>
            <label>
                <input type="checkbox" id="use-ajax" checked> 
                Enviar sem recarregar página (AJAX)
            </label>
        </div>

        <br>

        <button type="submit" id="submit-btn">Cadastrar</button>
    </form>

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
            
            if (!useAjax) return; // Let form submit normally
            
            e.preventDefault();
            
            const form = e.target;
            const submitBtn = document.getElementById('submit-btn');
            const messagesDiv = document.getElementById('form-messages');
            
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            messagesDiv.innerHTML = '';
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Enviando...';
            
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
                    messagesDiv.innerHTML = '<p style="color: green;">' + body.message + '</p>';
                    window.location.href = body.redirect_url;
                } else if (status === 422) {
                    // Validation errors
                    Object.keys(body.errors || {}).forEach(field => {
                        const errorSpan = document.getElementById(field + '-error');
                        if (errorSpan) {
                            errorSpan.textContent = body.errors[field][0];
                        }
                    });
                } else {
                    messagesDiv.innerHTML = '<p style="color: red;">Erro ao cadastrar empresa.</p>';
                }
            })
            .catch(error => {
                messagesDiv.innerHTML = '<p style="color: red;">Erro de conexão.</p>';
                console.error('Error:', error);
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Cadastrar';
            });
        });
    </script>
@endsection