<?php

use Illuminate\Support\Facades\Route;
use Modules\Game\App\Livewire\Page\GameIndex;
use Modules\Game\App\Livewire\Admin\GameEdit;
use Modules\Game\App\Livewire\Admin\GameForm;
use Modules\Game\App\Livewire\Admin\GameList;

// Rotas do módulo Game

// Página pública
Route::get('/games', GameIndex::class)
    ->name('games');

// Painel admin (autenticado e verificado)
Route::middleware(['auth', 'verified', 'web'])->group(function () {
    Route::get('games/games-list', GameList::class)
        ->name('games-list');

    Route::get('games/game-novo', GameForm::class)
        ->name('game-create');

    Route::get('games/game-edit/{game}/editar', GameEdit::class)
        ->name('game-edit');
});
