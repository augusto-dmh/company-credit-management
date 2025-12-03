<?php

namespace App\Services;

use App\Models\Empresa;

class EmpresaService
{
    public function create(array $data): Empresa
    {
        return Empresa::create([
            'nome' => $data['nome'],
            'cnpj' => $this->sanitizeCnpj($data['cnpj']),
            'icms_pago' => $data['icms_pago'],
            'credito_possivel' => $data['credito_possivel'],
        ]);
    }

    public function getAll()
    {
        return Empresa::latest()->get();
    }

    public function findById(int $id): ?Empresa
    {
        return Empresa::find($id);
    }

    protected function sanitizeCnpj(string $cnpj): string
    {
        return preg_replace('/\D/', '', $cnpj);
    }
}