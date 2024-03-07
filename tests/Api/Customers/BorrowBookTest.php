<?php

namespace Tests\Api\Customers;

use App\Enums\BookStatus;
use App\Models\Book;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BorrowBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_borrow_book_action_should_success_on_available_book()
    {
        $customer = Customer::factory()->create();
        $book = Book::factory()->available()->create();

        $pathToTest = route('customers.update.borrow', [$customer->id, $book->id]);
        $response = $this->put($pathToTest);

        $response->assertOk();
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'customer_id' => $customer->id,
        ]);
    }

    public function test_borrow_book_action_with_success_should_update_book_status_to_borrowed()
    {
        $customer = Customer::factory()->create();
        $book = Book::factory()->available()->create();

        $pathToTest = route('customers.update.borrow', [$customer->id, $book->id]);
        $this->put($pathToTest);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'status' => BookStatus::BORROWED,
            'customer_id' => $customer->id,
        ]);
    }

    public function test_borrow_book_action_should_fail_on_borrowed_book()
    {
        $customer = Customer::factory()->create();
        $book = Book::factory()->borrowed()->create();

        $pathToTest = route('customers.update.borrow', [$customer->id, $book->id]);
        $response = $this->put($pathToTest);

        $response->assertNotFound();
    }

    public function test_borrow_book_action_should_fail_on_not_available_book()
    {
        $customer = Customer::factory()->create();
        $book = Book::factory()->notAvailable()->create();

        $pathToTest = route('customers.update.borrow', [$customer->id, $book->id]);
        $response = $this->put($pathToTest);

        $response->assertNotFound();
    }

    public function test_borrow_book_action_with_fail_should_not_update_book_record()
    {
        $customer = Customer::factory()->create();
        $book = Book::factory()->notAvailable()->create();

        $pathToTest = route('customers.update.borrow', [$customer->id, $book->id]);
        $this->put($pathToTest);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'status' => $book->status,
            'customer_id' => $book->customer_id,
        ]);
    }

    public function test_borrow_book_action_should_fail_on_not_existing_book()
    {
        $customer = Customer::factory()->create();
        $book = Book::factory()->borrowed()->create();

        $pathToTest = route('customers.update.borrow', [$customer->id, $book->id + 1]);
        $response = $this->put($pathToTest);

        $response->assertNotFound();
    }

    public function test_borrow_book_action_should_fail_by_not_existing_customer_and_not_update_book()
    {
        $customer = Customer::factory()->create();
        $book = Book::factory()->available()->create();

        $pathToTest = route('customers.update.borrow', [$customer->id + 1, $book->id]);
        $response = $this->put($pathToTest);

        $response->assertNotFound();
        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'status' => $book->status,
            'customer_id' => $book->customer_id,
        ]);
    }
}
