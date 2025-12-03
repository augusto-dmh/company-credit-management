<?php

use App\Models\Empresa;

describe('Empresa Model', function () {
    it('calculates percentual credito correctly', function () {
        $empresa = new Empresa([
            'nome' => 'ACME LTDA',
            'cnpj' => '12345678000195',
            'icms_pago' => 1000000.00,
            'credito_possivel' => 200000.00,
        ]);

        expect($empresa->percentual_credito)->toBe(20.0);
    });

    it('returns zero percentual when icms_pago is zero', function () {
        $empresa = new Empresa([
            'nome' => 'ACME LTDA',
            'cnpj' => '12345678000195',
            'icms_pago' => 0,
            'credito_possivel' => 200000.00,
        ]);

        expect($empresa->percentual_credito)->toBe(0.0);
    });

    it('formats icms_pago correctly', function () {
        $empresa = new Empresa([
            'icms_pago' => 1000000.00,
            'credito_possivel' => 0,
        ]);

        expect($empresa->icms_pago_formatado)->toBe('R$ 1.000.000,00');
    });

    it('formats credito_possivel correctly', function () {
        $empresa = new Empresa([
            'icms_pago' => 0,
            'credito_possivel' => 200000.50,
        ]);

        expect($empresa->credito_possivel_formatado)->toBe('R$ 200.000,50');
    });
});
