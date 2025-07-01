<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    public function definition(): array
    {
        // You can move this to a separate config or file if preferred
        static $books = [
            ['title' => 'To Kill a Mockingbird', 'isbn' => '9780061120084'],
            ['title' => '1984', 'isbn' => '9780451524935'],
            ['title' => 'Pride and Prejudice', 'isbn' => '9780141439518'],
            ['title' => 'The Great Gatsby', 'isbn' => '9780743273565'],
            ['title' => 'The Catcher in the Rye', 'isbn' => '9780316769488'],
            ['title' => 'Moby-Dick', 'isbn' => '9781503280786'],
            ['title' => 'Brave New World', 'isbn' => '9780060850524'],
            ['title' => 'The Hobbit', 'isbn' => '9780547928227'],
            ['title' => 'Jane Eyre', 'isbn' => '9780142437209'],
            ['title' => 'Animal Farm', 'isbn' => '9780451526342'],
            ['title' => 'Wuthering Heights', 'isbn' => '9780141439556'],
            ['title' => 'The Lord of the Rings', 'isbn' => '9780544003415'],
            ['title' => 'Crime and Punishment', 'isbn' => '9780486415871'],
            ['title' => 'Great Expectations', 'isbn' => '9780141439563'],
            ['title' => 'Frankenstein', 'isbn' => '9780141439471'],
            ['title' => 'The Picture of Dorian Gray', 'isbn' => '9780141439570'],
            ['title' => 'Dracula', 'isbn' => '9780141439846'],
            ['title' => 'A Tale of Two Cities', 'isbn' => '9780141439600'],
            ['title' => 'Les Misérables', 'isbn' => '9780451419439'],
            ['title' => 'War and Peace', 'isbn' => '9781400079988'],
            ['title' => 'Anna Karenina', 'isbn' => '9780143035008'],
            ['title' => 'Fahrenheit 451', 'isbn' => '9781451673319'],
            ['title' => 'The Brothers Karamazov', 'isbn' => '9780374528379'],
            ['title' => 'The Divine Comedy', 'isbn' => '9780142437223'],
            ['title' => 'The Odyssey', 'isbn' => '9780140268867'],
            ['title' => 'The Iliad', 'isbn' => '9780140275360'],
            ['title' => 'Meditations', 'isbn' => '9780812968255'],
            ['title' => 'Don Quixote', 'isbn' => '9780060934347'],
            ['title' => 'The Stranger', 'isbn' => '9780679720201'],
            ['title' => 'The Metamorphosis', 'isbn' => '9780553213690'],
            ['title' => 'The Count of Monte Cristo', 'isbn' => '9780140449266'],
            ['title' => 'Ulysses', 'isbn' => '9780199535675'],
            ['title' => 'The Trial', 'isbn' => '9780805209990'],
            ['title' => 'The Sun Also Rises', 'isbn' => '9780743297332'],
            ['title' => 'Slaughterhouse-Five', 'isbn' => '9780440180296'],
            ['title' => 'The Old Man and the Sea', 'isbn' => '9780684801223'],
            ['title' => 'One Hundred Years of Solitude', 'isbn' => '9780060883287'],
            ['title' => 'Love in the Time of Cholera', 'isbn' => '9780307389732'],
            ['title' => 'A Farewell to Arms', 'isbn' => '9780684801469'],
            ['title' => 'Heart of Darkness', 'isbn' => '9780486264646'],
            ['title' => 'Lolita', 'isbn' => '9780679723165'],
            ['title' => 'Catch-22', 'isbn' => '9781451626650'],
            ['title' => 'On the Road', 'isbn' => '9780140283297'],
            ['title' => 'Beloved', 'isbn' => '9781400033416'],
            ['title' => 'Invisible Man', 'isbn' => '9780679732761'],
            ['title' => 'The Grapes of Wrath', 'isbn' => '9780143039433'],
            ['title' => 'Of Mice and Men', 'isbn' => '9780140177398'],
            ['title' => 'East of Eden', 'isbn' => '9780142000656'],
            ['title' => 'Their Eyes Were Watching God', 'isbn' => '9780061120060'],
            ['title' => 'The Bell Jar', 'isbn' => '9780061148514'],
        ];

        // Use the next book in the list
        $book = array_shift($books);

        return [
            'title' => $book['title'],
            'isbn' => Book::formatISBN($book['isbn']),
            'copies' => rand(2, 10),
        ];
    }
}
