<?php

use App\Livewire\Pages\Users;
use App\Livewire\Pages\Courses;
use Illuminate\Support\Facades\Route;

Route::view('/', 'login');
Route::view('/welcome', 'welcome');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::view('/', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');

    Route::get('users', Users::class)
        ->name('users');

    Route::get('courses', Courses::class)
        ->name('courses');
    

});


require __DIR__.'/auth.php';
