<?php

namespace App\Livewire\Pages;

use App\Enums\Role;
use App\Enums\Transaction;
use App\Livewire\Forms\UserForm;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Transactions extends Component
{
    use WithPagination;

    private $searchUserBy = ['key', 'name'];
    private $searchBookBy = ['isbn', 'title'];
    public $userTerm = '';
    public $bookTerm = '';
    public $selected = null;
    public $picks = [];
    public UserForm $form;

    public function proxyAction($name, User $user = null): void
    {
        $this->form->handleAction($name, $user);
    }

    public $borrowForm = 'form-borrow';

    public function render()
    {
        return view('livewire.pages.transactions', [
            'books' => Book::search($this->bookTerm, $this->searchBookBy)
                ->paginate(4, pageName: 'books'),
            'students' => User::where('role', Role::Student)
                ->search($this->userTerm, $this->searchUserBy)
                ->paginate(4, pageName: 'students'),
            'users' => User::whereHas('books')->with([
                'books' => function($q) { $q->limit(1); }
            ])->withCount([
                'books as borrow_count' => function($q) {
                     $q->where('type', Transaction::Borrow);
                },      
                'books as return_count' => function($q) { 
                    $q->where('type', Transaction::Return);
                }
            ])->paginate(6),
        ]);
    }

    public function registerBorrow(User $student)
    {
        if(!$student || count($this->picks) == 0) {
            return $this->js("alert('Selecciona un estudiante y al menos un libro')");
        }

        $exhaused = '';
        foreach($this->picks as $pick) {
            $book = Book::find($pick['id']);
            if(!$book) continue;
            if($book->copies > 0) {
                $book->decrement('copies');

                $student->books()->attach(
                    $book->id,
                    ['type' => Transaction::Borrow]
                );
            } else {
                $exhaused .= "Sin Copias disponibles para {$book->title}\n";
            }
        }
        $count = count($this->picks);

        $this->pull();
        
        return $exhaused != ''
            ? $this->js(
                "alert('$exhaused');".
                '$dispatch("close-form", "' . $this->borrowForm . '")'
            )
            : $this->js(
                "alert('$count libros prestados a $student->name');".
                '$dispatch("close-form", "' . $this->borrowForm . '")'
            );
    }

    public function updatedUserTerm(): void
    {
        $this->resetPage(pageName: 'students');
    }

    public function updatedBookTerm(): void
    {
        $this->resetPage(pageName: 'books');
    }
}
