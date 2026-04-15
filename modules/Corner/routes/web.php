<?php

use Illuminate\Support\Facades\Route;
use Modules\Corner\App\Livewire\Page\CornerIndex;
use Modules\Corner\App\Livewire\Admin\CornerEdit;
use Modules\Corner\App\Livewire\Admin\CornerForm;
use Modules\Corner\App\Livewire\Admin\CornerList;

// Rotas do módulo Corner

// Página pública
Route::get('/corners', CornerIndex::class)
    ->name('corners');

// Painel admin (autenticado e verificado)
Route::middleware(['auth', 'verified', 'web'])->group(function () {
    Route::get('corners/corners-list/{game}', CornerList::class)
        ->name('corners-list');

    Route::get('corners/corner-novo', CornerForm::class)
        ->name('corner-create');

    Route::get('corners/corner-edit/{{corners}}/editar', CornerEdit::class)
        ->name('corner-edit');
});
