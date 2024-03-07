<?php

namespace Tests\Api\Customers;

use App\Models\Book;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetCustomersTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_customers_action_returns_all_customers()
    {
        $expectedCount = random_int(0, 1000);
        Customer::factory($expectedCount)->create();

        $pathToTest = route('customers.find.all');
        $response = $this->get($pathToTest);

        $response->assertOk()->assertJsonCount($expectedCount);
    }

    public function test_get_customers_action_returns_firstname_and_lastname()
    {
        Customer::factory()->create();

        $pathToTest = route('customers.find.all');
        $response = $this->get($pathToTest);

        $response
            ->assertOk()
            ->assertJsonStructure([[
                'id',
                'first_name',
                'last_name',
            ]]);
    }

    public function test_get_customers_action_should_returns_customers_without_books()
    {
        Book::factory()->borrowed()->create();

        $pathToTest = route('customers.find.all');
        $response = $this->get($pathToTest);

        $customers = $response->json();
        $hasBooksKey = collect($customers)->contains(function ($customer) {
            return array_key_exists('books', $customer);
        });

        $this->assertFalse($hasBooksKey);
    }
}
