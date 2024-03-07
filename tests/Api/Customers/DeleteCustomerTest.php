<?php

namespace Tests\Api\Customers;

use App\Models\Book;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteCustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_customer_action_should_delete_customer()
    {
        $customer = Customer::factory()->create();

        $pathToTest = route('customers.delete', [$customer->id]);
        $response = $this->delete($pathToTest);

        $response->assertOk();
        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    }

    public function test_delete_customer_with_borrowed_book_should_returns_404()
    {
        $customer = Customer::factory()->create();
        Book::factory()->for($customer)->create();

        $pathToTest = route('customers.delete', [$customer->id]);
        $response = $this->delete($pathToTest);

        $response->assertNotFound();
    }

    public function test_delete_customer_by_not_existing_id_should_returns_404()
    {
        $customer = Customer::factory()->create();

        $pathToTest = route('customers.delete', [$customer->id + 1]);
        $response = $this->delete($pathToTest);

        $response->assertNotFound();
    }
}
