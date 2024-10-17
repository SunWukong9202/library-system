<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\BookForm;
use App\Models\Book;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Books extends Component
{
    use WithPagination;

    public BookForm $form;

    public function proxyAction($name, Book $book = null): void
    {
        $this->form->handleAction($name, $book);
    }

    public function render()
    {
        return view('livewire.pages.books', [
            'books' => Book::paginate(6)
        ]);
    }
}
