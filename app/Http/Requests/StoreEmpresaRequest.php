<?php

namespace App\Http\Requests;

use App\Rules\CnpjValido;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmpresaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'string', new CnpjValido],
            'icms_pago' => ['required', 'numeric', 'min:0'],
            'credito_possivel' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome da empresa é obrigatório.',
            'nome.max' => 'O nome da empresa não pode ter mais de 255 caracteres.',
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'icms_pago.required' => 'O valor de ICMS pago é obrigatório.',
            'icms_pago.numeric' => 'O valor de ICMS deve ser um número.',
            'icms_pago.min' => 'O valor de ICMS não pode ser negativo.',
            'credito_possivel.required' => 'O valor de crédito possível é obrigatório.',
            'credito_possivel.numeric' => 'O valor de crédito deve ser um número.',
            'credito_possivel.min' => 'O valor de crédito não pode ser negativo.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    protected function prepareForValidation(): void
    {
        if ($this->cnpj) {
            $this->merge([
                'cnpj' => preg_replace('/\D/', '', $this->cnpj),
            ]);
        }
    }
}
