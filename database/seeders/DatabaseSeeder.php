<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Enums\Transaction;
use App\Models\Book;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'email' => 'admin@gmail.com',
            'role' => Role::Admin
        ]);
        
        User::factory()->create([
            'role' => Role::Librarian,
            'email' => 'librarian@gmail.com'
        ]);

        $students = User::factory()->count(10)->create([
            'role' => Role::Student,
            'email' => null,
        ]);

        $books = Book::factory()->count(20)->create();

        $students->each(function ($student) use ($books) {
            // Random number of books to borrow
            $borrowCount = rand(1, 4);
            $booksToBorrow = $books->shuffle()->take($borrowCount);

            foreach ($booksToBorrow as $book) {
                // Only borrow if copies are available
                if ($book->copies > 0) {
                    // Decrement copies
                    $book->decrement('copies');

                    // Attach as borrow
                    
                    $created = now()->subDays(5, 15);
                    $student->books()->attach(
                        $book->id,
                        [
                            'type' => Transaction::Borrow, 
                            'created_at' => $created,
                            'updated_at' => $created
                        ]
                    );

                    $pivot = DB::table('book_user')
                        ->where('user_id', $student->id)
                        ->where('book_id', $book->id)
                        ->latest('id')
                        ->first();
            
                    // 50% chance to return the book
                    if (rand(0, 1)) {
                        
                        // Increment copies
                        $book->increment('copies');

                        // Attach as return
                        DB::table('book_user')
                            ->where('id', $pivot->id)
                            ->update([
                                'type' => Transaction::Return,
                                'updated_at' => $created->addDays(rand(2, 3))
                            ]);
                    }
                }
            }
        });
    }
}
