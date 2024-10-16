<?php

namespace App\Livewire\Forms;

use App\Enums\Role;
use App\Models\Book;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BookForm extends Form
{
    public ?Book $book = null;

    public $title = '';
    public $isbn = '';
    public $copies = 1;
    // public $is
    public function rules(): array
    {
        return [
            'isbn' => [

                Rule::unique('books')->ignore($this->book?->id),
            ]
        ];
    }

    public function setBook(Book $book): void
    {
        $this->book = $book;
        $this->title = $book->title;
        $this->isbn = $book->isbn;
        $this->copies = $book->copies;
    }

    public function updateOrCreate(): void
    {
        $this->validate();

        Book::updateOrCreate(
            ['id' => $this->book?->id],
            $this->except('book')
        );
    }
}
