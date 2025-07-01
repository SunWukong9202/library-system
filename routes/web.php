<?php

use App\Livewire\Pages\Books;
use App\Livewire\Pages\Transactions;
use App\Livewire\Pages\Users;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'login');

// Route::view('/welcome', 'welcome');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::view('/dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::get('users', Users::class)
        ->name('users');

    Route::get('books', Books::class)
        ->name('books');

    Route::get('transaction', Transactions::class)
        ->name('transactions');
});


require __DIR__.'/auth.php';
