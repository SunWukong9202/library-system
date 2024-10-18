<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isbn = Book::formatISBN(fake()->randomElement([fake()->isbn10(), fake()->isbn13()]));

        return [
            'title' => fake()->sentence(3),
            'isbn' => $isbn,
            'copies' => rand(2, 10),
        ];
    }
}
