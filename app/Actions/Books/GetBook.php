<?php

namespace App\Actions\Books;

use App\Models\Book;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBook
{
    use AsAction;

    public function handle(Book $book): Book
    {
        $book->load(['customer']);

        return $book;
    }

    public function asController(Book $book)
    {
        $bookDetails = $this->handle($book);

        return response($bookDetails);
    }
}
