<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Volt::route('/dashboard', 'pages.dashboard')->lazy()->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
