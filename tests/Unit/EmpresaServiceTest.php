<?php

use App\Models\Empresa;
use App\Services\EmpresaService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('EmpresaService', function () {
    it('creates an empresa with sanitized cnpj', function () {
        $service = new EmpresaService;

        $empresa = $service->create([
            'nome' => 'ACME LTDA',
            'cnpj' => '12.345.678/0001-95',
            'icms_pago' => 1000000.00,
            'credito_possivel' => 200000.00,
        ]);

        expect($empresa)->toBeInstanceOf(Empresa::class)
            ->and($empresa->cnpj)->toBe('12345678000195')
            ->and($empresa->nome)->toBe('ACME LTDA');
    });

    it('retrieves all empresas ordered by latest', function () {
        $service = new EmpresaService;

        Empresa::factory()->count(3)->create();

        $empresas = $service->getAll();

        expect($empresas)->toHaveCount(3);
    });

    it('finds empresa by id', function () {
        $service = new EmpresaService;
        $empresa = Empresa::factory()->create();

        $found = $service->findById($empresa->id);

        expect($found->id)->toBe($empresa->id);
    });

    it('returns null when empresa not found', function () {
        $service = new EmpresaService;

        $found = $service->findById(999);

        expect($found)->toBeNull();
    });
});
