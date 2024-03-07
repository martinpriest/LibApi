<?php

namespace Tests\Api\Customers;

use App\Models\Book;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetCustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_customer_action_should_returns_customer_with_books_key()
    {
        $customer = Customer::factory()->create();

        $pathToTest = route('customers.find.one', [$customer->id]);
        $response = $this->get($pathToTest);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'first_name',
                'last_name',
                'books',
            ]);
    }

    public function test_get_customer_action_should_returns_customer_with_all_books()
    {
        $customer = Customer::factory()->create();
        $borrowedBookCount = random_int(1, 50);
        Book::factory($borrowedBookCount)->for($customer)->create();

        $pathToTest = route('customers.find.one', [$customer->id]);
        $response = $this->get($pathToTest);

        $data = $response->json();
        $this->assertCount($borrowedBookCount, $data['books']);
    }

    public function test_get_customer_by_not_existing_id_should_returns_404()
    {
        $customer = Customer::factory()->create();

        $pathToTest = route('customers.find.one', [$customer->id + 1]);
        $response = $this->get($pathToTest);

        $response->assertNotFound();
    }
}
