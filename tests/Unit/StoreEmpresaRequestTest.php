<?php

use App\Http\Requests\StoreEmpresaRequest;
use Illuminate\Support\Facades\Validator;

describe('StoreEmpresaRequest', function () {
    function validateRequest(array $data): \Illuminate\Validation\Validator
    {
        $request = new StoreEmpresaRequest();

        return Validator::make($data, $request->rules(), $request->messages());
    }

    it('passes with valid data', function () {
        $validator = validateRequest([
            'nome' => 'ACME LTDA',
            'cnpj' => '12345678000195',
            'icms_pago' => 1000000.00,
            'credito_possivel' => 200000.00,
        ]);

        expect($validator->passes())->toBeTrue();
    });

    it('fails when nome is missing', function () {
        $validator = validateRequest([
            'cnpj' => '12345678000195',
            'icms_pago' => 1000000.00,
            'credito_possivel' => 200000.00,
        ]);

        expect($validator->fails())->toBeTrue()
            ->and($validator->errors()->has('nome'))->toBeTrue();
    });

    it('fails when cnpj is invalid', function () {
        $validator = validateRequest([
            'nome' => 'ACME LTDA',
            'cnpj' => '123',
            'icms_pago' => 1000000.00,
            'credito_possivel' => 200000.00,
        ]);

        expect($validator->fails())->toBeTrue()
            ->and($validator->errors()->has('cnpj'))->toBeTrue();
    });

    it('fails when icms_pago is negative', function () {
        $validator = validateRequest([
            'nome' => 'ACME LTDA',
            'cnpj' => '12345678000195',
            'icms_pago' => -100,
            'credito_possivel' => 200000.00,
        ]);

        expect($validator->fails())->toBeTrue()
            ->and($validator->errors()->has('icms_pago'))->toBeTrue();
    });

    it('fails when credito_possivel is negative', function () {
        $validator = validateRequest([
            'nome' => 'ACME LTDA',
            'cnpj' => '12345678000195',
            'icms_pago' => 1000000.00,
            'credito_possivel' => -100,
        ]);

        expect($validator->fails())->toBeTrue()
            ->and($validator->errors()->has('credito_possivel'))->toBeTrue();
    });

    it('accepts cnpj with mask', function () {
        $validator = validateRequest([
            'nome' => 'ACME LTDA',
            'cnpj' => '12.345.678/0001-95',
            'icms_pago' => 1000000.00,
            'credito_possivel' => 200000.00,
        ]);

        expect($validator->passes())->toBeTrue();
    });
});
