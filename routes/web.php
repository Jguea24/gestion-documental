<?php

use App\Http\Controllers\CarpetaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SemestreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified', 'permission:dashboard.ver'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('semestres', SemestreController::class)->middleware('permission:semestres.ver');
    Route::resource('carpetas', CarpetaController::class)->middleware('permission:carpetas.ver');
    Route::resource('documentos', DocumentoController::class)->middleware('permission:documentos.ver');

    Route::get('documentos/{documento}/descargar', [DocumentoController::class, 'download'])
        ->middleware('permission:documentos.descargar')
        ->name('documentos.download');

    Route::get('documentos/{documento}/preview', [DocumentoController::class, 'preview'])
        ->middleware('permission:documentos.ver')
        ->name('documentos.preview');
});

require __DIR__.'/auth.php';
