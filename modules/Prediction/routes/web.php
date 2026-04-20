<?php

use Illuminate\Support\Facades\Route;
use Modules\Prediction\App\Livewire\Page\PredictionIndex;
use Modules\Prediction\App\Livewire\Admin\PredictionEdit;
use Modules\Prediction\App\Livewire\Admin\PredictionHistory;
use Modules\Prediction\App\Livewire\Admin\PredictionList;

// Rotas do módulo Prediction

// Página pública
Route::get('/predictions', PredictionIndex::class)
    ->name('predictions');

// Painel admin (autenticado e verificado)
Route::middleware(['auth', 'verified', 'web'])->group(function () {
    Route::get('predictions/predictions-list', PredictionList::class)
        ->name('predictions-list');

    Route::get('predictions/prediction-historico', PredictionHistory::class)
        ->name('prediction-history');

    Route::get('predictions/prediction-edit/{{predictions}}/editar', PredictionEdit::class)
        ->name('prediction-edit');
});
