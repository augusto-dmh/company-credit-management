<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CnpjValido implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cnpj = preg_replace('/\D/', '', $value);

        if (strlen($cnpj) !== 14) {
            $fail('O CNPJ deve ter 14 dígitos.');

            return;
        }

        // Rejeita CNPJs com todos os dígitos iguais
        if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
            $fail('O CNPJ informado é inválido.');

            return;
        }

        // Validação dos dígitos verificadores
        if (! $this->validarDigitos($cnpj)) {
            $fail('O CNPJ informado é inválido.');
        }
    }

    private function validarDigitos(string $cnpj): bool
    {
        // Primeiro dígito verificador
        $soma = 0;
        $multiplicadores1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0; $i < 12; $i++) {
            $soma += (int) $cnpj[$i] * $multiplicadores1[$i];
        }

        $resto = $soma % 11;
        $digito1 = $resto < 2 ? 0 : 11 - $resto;

        if ((int) $cnpj[12] !== $digito1) {
            return false;
        }

        // Segundo dígito verificador
        $soma = 0;
        $multiplicadores2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        for ($i = 0; $i < 13; $i++) {
            $soma += (int) $cnpj[$i] * $multiplicadores2[$i];
        }

        $resto = $soma % 11;
        $digito2 = $resto < 2 ? 0 : 11 - $resto;

        return (int) $cnpj[13] === $digito2;
    }
}
