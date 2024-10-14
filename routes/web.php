<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'login');
Route::view('/welcome', 'welcome');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::view('/', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');
});


require __DIR__.'/auth.php';
