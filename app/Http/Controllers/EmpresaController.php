<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpresaRequest;
use App\Services\EmpresaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class EmpresaController extends Controller
{
    public function __construct(
        protected EmpresaService $empresaService
    ) {}

    public function index(): View
    {
        $empresas = $this->empresaService->getAll();

        return view('empresa.index', compact('empresas'));
    }

    public function create(): View
    {
        return view('empresa.create');
    }

    public function store(StoreEmpresaRequest $request): RedirectResponse
    {
        $empresa = $this->empresaService->create($request->validated());

        return redirect()
            ->route('empresa.relatorio', $empresa)
            ->with('success', 'Empresa cadastrada com sucesso!');
    }

    public function relatorio(int $id): View
    {
        $empresa = $this->empresaService->findById($id);

        if (! $empresa) {
            abort(404, 'Empresa não encontrada.');
        }

        return view('empresa.relatorio', compact('empresa'));
    }

    public function exportPdf(int $id): Response
    {
        $empresa = $this->empresaService->findById($id);

        if (! $empresa) {
            abort(404, 'Empresa não encontrada.');
        }

        $pdf = Pdf::loadView('empresa.relatorio-pdf', compact('empresa'));

        return $pdf->download("relatorio-{$empresa->cnpj}.pdf");
    }
}
