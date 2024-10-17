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
    public $name = 'form-book';

    #[Validate('between:4,80', attribute: 'Titulo')]
    public $title = '';
    #[Validate()]
    public $isbn = '';
    #[Validate('between:1,255', attribute: 'Copias')]
    public $copies = 1; //MAX: 255

    public $isbn13 = false;
// 13: XXX-X-XXX-XXXXX-Z len = 17
// 10: X-XXX-XXXXX-Y len = 13
    public function rules(): array
    {
        return [
            'isbn' => [
                $this->isbn13 ? 'size:17' : 'size:13',
                Rule::unique('books')->ignore($this->book?->id),
            ]
        ];
    }

    public function set(Book $book): void
    {
        $this->book = $book;
        $this->isbn13 = strlen($book->isbn) == 17;
        $this->title = $book->title;
        $this->isbn = substr($book->isbn, 0, strlen($book->isbn) - 2);
        $this->copies = $book->copies;
    }

    public function handleAction($name, Book $book) 
    {
        match($name) {
            'load' => $this->load($book),
            'delete' => $this->delete($book),
            'create' => $this->create(),
            'update' => $this->update(),
        };
    }

    public function load(Book $book): void
    {
        $this->set($book);

        $this->component?->js('$dispatch("open-form", "'.$this->name.'")');
    }

    public function delete(Book $book): void
    {
        $book->delete();
        
        $this->pull();

        $this->component?->resetPage();

        $this->component?->js(
            '$dispatch("close-form", "'.$this->name.'");'.
            "alert('Libro $book->title Eliminado!')"
        );
    }

    public function create(): void
    {
        $title = $this->updateOrCreate();

        $this->pull();
        
        $this->component?->js(
            '$dispatch("close-form", "'.$this->name.'");'.
            "alert('Libro $title creado!')"
        );
    }

    public function update(): void
    {        
        $title = $this->updateOrCreate();

        $this->pull();

        $this->component->js(
            "alert('Libro $title editado!');".
            '$dispatch("close-form", "'.$this->name.'")'
        );
    }

    public function updateOrCreate(): string
    {
        $this->validate();

        Book::updateOrCreate(
            ['id' => $this->book?->id],
            $this->except('book', 'isbn13', 'name')
        );

        return $this->title;
    }
}
