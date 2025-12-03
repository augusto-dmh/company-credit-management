<?php

use App\Rules\CnpjValido;

describe('CnpjValido Rule', function () {
    it('validates a correct CNPJ', function () {
        $rule = new CnpjValido;
        $failed = false;

        $rule->validate('cnpj', '11222333000181', function () use (&$failed) {
            $failed = true;
        });

        expect($failed)->toBeFalse();
    });

    it('rejects CNPJ with wrong check digits', function () {
        $rule = new CnpjValido;
        $failed = false;

        $rule->validate('cnpj', '11222333000199', function () use (&$failed) {
            $failed = true;
        });

        expect($failed)->toBeTrue();
    });

    it('rejects CNPJ with all same digits', function () {
        $rule = new CnpjValido;
        $failed = false;

        $rule->validate('cnpj', '11111111111111', function () use (&$failed) {
            $failed = true;
        });

        expect($failed)->toBeTrue();
    });

    it('rejects CNPJ with wrong length', function () {
        $rule = new CnpjValido;
        $failed = false;

        $rule->validate('cnpj', '1234567890', function () use (&$failed) {
            $failed = true;
        });

        expect($failed)->toBeTrue();
    });

    it('validates CNPJ with mask', function () {
        $rule = new CnpjValido;
        $failed = false;

        // O prepareForValidation remove a máscara antes
        $cnpjSemMascara = preg_replace('/\D/', '', '11.222.333/0001-81');

        $rule->validate('cnpj', $cnpjSemMascara, function () use (&$failed) {
            $failed = true;
        });

        expect($failed)->toBeFalse();
    });
});
