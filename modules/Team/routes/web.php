<?php

use Illuminate\Support\Facades\Route;
use Modules\Team\App\Livewire\Page\TeamIndex;
use Modules\Team\App\Livewire\Admin\TeamEdit;
use Modules\Team\App\Livewire\Admin\TeamForm;
use Modules\Team\App\Livewire\Admin\TeamList;

// Rotas do módulo Team

// Página pública
Route::get('/teams', TeamIndex::class)
    ->name('teams');

// Painel admin (autenticado e verificado)
Route::middleware(['auth', 'verified', 'web'])->group(function () {
    Route::get('teams/teams-list', TeamList::class)
        ->name('teams-list');

    Route::get('teams/team-novo', TeamForm::class)
        ->name('team-create');

    Route::get('teams/team-edit/{team}/editar', TeamEdit::class)
        ->name('team-edit');
});
