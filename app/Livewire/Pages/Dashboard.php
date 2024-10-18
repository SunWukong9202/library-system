<?php

namespace App\Livewire\Pages;

use App\Models\Book;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.pages.dashboard', [
            'books' => Book::whereHas('users')
                ->withCount('users')->orderBy('users_count', 'desc')
                ->paginate(8),
            'readers' => User::whereHas('books')
                ->withCount('books')->orderBy('books_count', 'desc')
                ->paginate(8)
        ]);
    }
}
