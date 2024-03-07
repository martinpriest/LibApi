<?php

namespace Tests\Api\Books;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetBooksTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_books_action_with_no_query_param_should_success()
    {
        Book::factory(5)->create();
        Book::factory(5)->borrowed()->create();

        $pathToTest = route('books.find.all');
        $response = $this->get($pathToTest);

        $response->assertOk();
        $response->assertJsonCount(10, 'data');
    }

    public function test_get_books_action_should_be_paginated_by_20_results_by_default()
    {
        $bookCount = random_int(0, 19);
        Book::factory($bookCount)->create();

        $pathToTest = route('books.find.all');
        $response = $this->get($pathToTest);

        $response->assertOk();
        $response->assertJsonCount(min($bookCount, 20), 'data');

        Book::factory(60)->create();
        $response = $this->get($pathToTest);

        $response->assertJsonCount(20, 'data');
    }

    public function test_get_books_action_should_return_results_with_pagination_keys()
    {
        Book::factory(60)->create();

        $pathToTest = route('books.find.all');
        $response = $this->get($pathToTest);

        $response->assertJsonStructure([
            'current_page',
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
            'data',
        ]);
    }
}
