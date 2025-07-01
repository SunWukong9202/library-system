<?php

namespace App\Livewire\Pages;

use App\Enums\Role;
use App\Enums\Transaction;
use App\Livewire\Forms\UserForm;
use App\Models\Book;
use App\Models\User;
use App\Utils\WithReadableDates;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Transactions extends Component
{
    use WithPagination, WithReadableDates;

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
            'transactions' => DB::table('book_user')
                ->join('users', 'book_user.user_id', '=', 'users.id')
                ->join('books', 'book_user.book_id', '=', 'books.id')
                ->select(
                    'book_user.id as pivot_id',
                    'book_user.type',
                    'book_user.created_at as pivot_created_at',
                    'book_user.updated_at as pivot_updated_at',
                    'users.id as user_id',
                    'users.name as user_name',
                    'users.key as user_key',
                    'users.role as user_role',
                    'books.id as book_id',
                    'books.title as book_title',
                    'books.isbn as book_isbn'
                )
                ->orderByDesc('pivot_created_at')
                ->paginate(10),
        ]);
    }

    // 'users' => User::whereHas('books')->with([
    //             'books' => function(Builder $q) { $q->groupBy('book_id')->limit(1); }
    //         ])->withCount([
    //             'books as borrow_count' => function($q) {
    //                  $q->where('type', Transaction::Borrow);
    //             },      
    //             'books as return_count' => function($q) { 
    //                 $q->where('type', Transaction::Return);
    //             }
    //         ])->paginate(6),

//     > User::select('id', 'key', 'role')->whereHas('books')->with('books')->get()->
// map(fn($user) => $user->books->map(function($book) use($user) { return ['user'
//  => collect($user)->except(['books']), 'book' => collect(['type' => $book->tra
// nsaction->type, 'date' => ])]; })->first());

    public function registerReturn(int $id, Book $book): void
    {
        $book->increment('copies');
        
        DB::table('book_user')
            ->where('id', $id)
            ->update([
                'type' => Transaction::Return,
                'updated_at' => now()
            ]);

        $this->js("alert('".trans('Return successfully registered!')."')");
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
