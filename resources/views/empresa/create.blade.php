@extends('layouts.app')

@section('title', 'Cadastrar Empresa')

@section('content')
    <h2>Cadastrar Empresa</h2>

    <form action="{{ route('empresa.store') }}" method="POST">
        @csrf

        <div>
            <label for="nome">Nome da Empresa:</label><br>
            <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required>
            @error('nome')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="cnpj">CNPJ:</label><br>
            <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj') }}" 
                   placeholder="00.000.000/0000-00" maxlength="18" required>
            @error('cnpj')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="icms_pago">Valor Total de ICMS Pago (R$):</label><br>
            <input type="number" id="icms_pago" name="icms_pago" 
                   value="{{ old('icms_pago') }}" step="0.01" min="0" required>
            @error('icms_pago')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <div>
            <label for="credito_possivel">Valor de Créditos Possíveis (R$):</label><br>
            <input type="number" id="credito_possivel" name="credito_possivel" 
                   value="{{ old('credito_possivel') }}" step="0.01" min="0" required>
            @error('credito_possivel')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <button type="submit">Cadastrar</button>
    </form>

    <script>
        // Simple CNPJ mask
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
    </script>
@endsection