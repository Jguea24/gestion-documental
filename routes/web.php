<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ExplorerController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrashController;
use App\Http\Controllers\UserController;
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

    Route::get('/explorer', [ExplorerController::class, 'index'])
        ->middleware('permission:explorer.view')
        ->name('explorer.index');

    Route::post('/folders', [FolderController::class, 'store'])
        ->middleware('permission:folders.create')
        ->name('folders.store');
    Route::patch('/folders/{folder}', [FolderController::class, 'update'])
        ->middleware('permission:folders.rename')
        ->name('folders.update');
    Route::patch('/folders/{folder}/move', [FolderController::class, 'move'])
        ->middleware('permission:folders.move')
        ->name('folders.move');
    Route::delete('/folders/{folder}', [FolderController::class, 'destroy'])
        ->middleware('permission:folders.delete')
        ->name('folders.destroy');
    Route::patch('/folders/{folder}/restore', [FolderController::class, 'restore'])
        ->middleware('permission:folders.restore')
        ->name('folders.restore');
    Route::delete('/folders/{folder}/force-delete', [FolderController::class, 'forceDelete'])
        ->middleware('permission:folders.delete')
        ->name('folders.force-delete');

    Route::post('/documents', [DocumentController::class, 'store'])
        ->middleware('permission:documents.upload')
        ->name('documents.store');
    Route::patch('/documents/{document}', [DocumentController::class, 'update'])
        ->middleware('permission:documents.rename')
        ->name('documents.update');
    Route::patch('/documents/{document}/move', [DocumentController::class, 'move'])
        ->middleware('permission:documents.move')
        ->name('documents.move');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])
        ->middleware('permission:documents.download')
        ->name('documents.download');
    Route::get('/documents/{document}/preview', [DocumentController::class, 'preview'])
        ->middleware('permission:documents.preview')
        ->name('documents.preview');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])
        ->middleware('permission:documents.delete')
        ->name('documents.destroy');
    Route::patch('/documents/{document}/restore', [DocumentController::class, 'restore'])
        ->middleware('permission:documents.restore')
        ->name('documents.restore');
    Route::delete('/documents/{document}/force-delete', [DocumentController::class, 'forceDelete'])
        ->middleware('permission:documents.delete')
        ->name('documents.force-delete');

    Route::get('/trash', TrashController::class)
        ->middleware('permission:trash.view')
        ->name('trash.index');

    Route::resource('users', UserController::class)
        ->except(['show'])
        ->middleware('permission:users.view');
});

require __DIR__.'/auth.php';
