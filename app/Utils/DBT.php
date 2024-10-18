<?php

namespace App\Utils;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class DBT {
    public static function db_book_user()
    {
        return DB::table('book_user')
            ->select('book_id', 'user_id', 'type')
            ->groupBy('book_id', 'user_id', 'type');
    }

    // public static function ()
    // {
    //     returnUser::whereHas('books')->with([
    //         'books' => function($q) { $q->select(''
                            
    //         )->groupBy('books.book_id')->limit(1); }
    //     ])->withCount([
    //         'books as borrow_count' => function($q) {
    //              $q->where('type', Transaction::Borrow);
    //         },      
    //         'books as return_count' => function($q) { 
    //             $q->where('type', Transaction::Return);
    //         }
    //     ]))->get(),
    // }

    public static function group()
    {
        // map(fn($user) => ['user' => collect($user)->except(['books'])->all(), 
        // collect($user->books->all())->groupBy(fn($book) => $book->type)]);

        // return $map(fn($user) => [
        //     'user' => collect($user)->except(['books']), 'books' => $user->books->groupBy(fn($book) => $book->id)->map(fn($group) => ['book' => $group->first(), 'count' => $group->count()])])->first();


        //     $c()->map(fn($user) => ['user' => collect($user)->except(['books']), 'books'
        //     => $user->books->groupBy(fn($book) => $book->id)->map(fn($group) => ['book' =
        //    > collect($group->first())->except(['transaction']), 'type' => $group->countBy
        //    (fn($book) => $book->transaction->type)->toArray()])])->first();
    }
}