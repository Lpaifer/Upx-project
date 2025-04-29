<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormularioController;

Route::get('/formulario', [FormularioController::class, 'index']);
Route::post('/formulario', [FormularioController::class, 'store'])->name('formulario.store');
