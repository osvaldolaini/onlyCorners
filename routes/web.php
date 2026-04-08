<?php

use App\Livewire\Admin\Page\Panel;
use App\Livewire\Admin\Settings\Logs;
use App\Livewire\Admin\Settings\Settings;
use App\Livewire\Admin\Users\UserForm;
use App\Livewire\Admin\Users\UserList;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware([
    'auth',
    'verified'
])->group(function () {
    Route::get('/admin/dashboard', Panel::class)->name('dashboard');
    // Route::get('/versoes', ReadmeView::class)->name('versions');
});

Route::middleware([
    'auth',
    'verified'
])->group(function () {
    Route::get('/admin/configurações-gerais', Settings::class)->name('settings');
    Route::get('/log-viewer', Logs::class)->name('logs');
});
Route::middleware([
    'auth',
    'verified'
])->group(function () {
    Route::get('/cadastros/usuários', UserList::class)
        ->name('users-list');
    Route::get('/cadastros/usuários/novo', UserForm::class)
        ->name('user-create');
    Route::get('/cadastros/usuários/{user}/editar', UserForm::class)
        ->name('user-edit');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
