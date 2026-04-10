<?php

use Illuminate\Support\Facades\Route;
use Modules\Championship\App\Livewire\Page\ChampionshipIndex;
use Modules\Championship\App\Livewire\Admin\ChampionshipEdit;
use Modules\Championship\App\Livewire\Admin\ChampionshipForm;
use Modules\Championship\App\Livewire\Admin\ChampionshipList;

// Rotas do módulo Championship

// Página pública
Route::get('/championships', ChampionshipIndex::class)
    ->name('championships');

// Painel admin (autenticado e verificado)
Route::middleware(['auth', 'verified', 'web'])->group(function () {
    Route::get('championships/championships-list', ChampionshipList::class)
        ->name('championships-list');

    Route::get('championships/championship-novo', ChampionshipForm::class)
        ->name('championship-create');

    Route::get('championships/championship-edit/{championship}/editar', ChampionshipEdit::class)
        ->name('championship-edit');
});
