<?php

namespace Tests\Api\Customers;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_book_action_should_return_book_with_all_details()
    {
        $book = Book::factory()->create();

        $pathToTest = route('books.find.one', [$book->id]);
        $response = $this->get($pathToTest);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'status',
                'title',
                'author',
                'publication_date',
                'publishing_house',
                'customer_id',
                'customer',
            ]);
    }

    public function test_get_borrowed_book_should_return_customer_details()
    {
        $book = Book::factory()->borrowed()->create();

        $pathToTest = route('books.find.one', [$book->id]);
        $response = $this->get($pathToTest);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'status',
                'title',
                'author',
                'publication_date',
                'publishing_house',
                'customer_id',
                'customer' => [
                    'id',
                    'first_name',
                    'last_name',
                ],
            ]);
    }

    public function test_get_book_by_not_existing_id_should_returns_404()
    {
        $book = Book::factory()->create();

        $pathToTest = route('books.find.one', [$book->id + 1]);
        $response = $this->get($pathToTest);

        $response->assertNotFound();
    }
}
