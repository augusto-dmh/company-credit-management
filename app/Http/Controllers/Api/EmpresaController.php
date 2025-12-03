<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmpresaRequest;
use App\Services\EmpresaService;
use Illuminate\Http\JsonResponse;

class EmpresaController extends Controller
{
    public function __construct(
        protected EmpresaService $empresaService
    ) {}

    public function store(StoreEmpresaRequest $request): JsonResponse
    {
        $empresa = $this->empresaService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Empresa cadastrada com sucesso!',
            'data' => [
                'id' => $empresa->id,
                'nome' => $empresa->nome,
                'cnpj' => $empresa->cnpj,
                'icms_pago' => $empresa->icms_pago,
                'icms_pago_formatado' => $empresa->icms_pago_formatado,
                'credito_possivel' => $empresa->credito_possivel,
                'credito_possivel_formatado' => $empresa->credito_possivel_formatado,
                'percentual_credito' => $empresa->percentual_credito,
            ],
            'redirect_url' => route('empresa.relatorio', $empresa->id),
        ], 201);
    }
}
