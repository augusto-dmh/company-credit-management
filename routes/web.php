<?php

use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('empresa')->name('empresa.')->group(function () {
    Route::get('/', [EmpresaController::class, 'index'])->name('index');
    Route::get('/cadastro', [EmpresaController::class, 'create'])->name('create');
    Route::post('/', [EmpresaController::class, 'store'])->name('store');
    Route::get('/{id}/relatorio', [EmpresaController::class, 'relatorio'])->name('relatorio');
});
