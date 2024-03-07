<?php

namespace Tests\Api\Customers;

use App\Enums\BookStatus;
use App\Models\Book;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReturnBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_customer_can_return_book_and_update_book_status_and_set_customer_to_null()
    {
        $ownerCustomer = Customer::factory()->create();
        $book = Book::factory()->for($ownerCustomer)->create();

        $pathToTest = route('customers.update.return', [
            'customer' => $ownerCustomer->id,
            'book' => $book->id,
        ]);
        $response = $this->put($pathToTest);

        $response->assertOk();
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'status' => BookStatus::AVAILABLE,
            'customer_id' => null,
        ]);
    }

    public function test_foreign_user_cannot_return_book()
    {
        $ownerCustomer = Customer::factory()->create();
        $book = Book::factory()->borrowedBy($ownerCustomer->id)->create();
        $foreignCustomer = Customer::factory()->create();

        $pathToTest = route('customers.update.return', [
            'customer' => $foreignCustomer->id,
            'book' => $book->id,
        ]);
        $response = $this->put($pathToTest);

        $response->assertNotFound();
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'status' => BookStatus::BORROWED,
            'customer_id' => $ownerCustomer->id,
        ]);
    }
}
