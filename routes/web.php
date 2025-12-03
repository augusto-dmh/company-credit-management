<?php

use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('empresa.create'));

Route::prefix('empresa')->name('empresa.')->group(function () {
    Route::get('/', [EmpresaController::class, 'index'])->name('index');
    Route::get('/cadastro', [EmpresaController::class, 'create'])->name('create');
    Route::post('/', [EmpresaController::class, 'store'])->name('store');
    Route::get('/{id}/relatorio', [EmpresaController::class, 'relatorio'])->name('relatorio');
    Route::get('/{id}/pdf', [EmpresaController::class, 'exportPdf'])->name('pdf');
});
