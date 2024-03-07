<?php

namespace Tests\Api\Customers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCustomerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_creating_customer_success_with_valid_data()
    {
        $data = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
        ];

        $pathToTest = route('customers.create');
        $response = $this->post($pathToTest, $data);

        $response->assertOk();
        $this->assertDatabaseHas('customers', [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
        ]);
    }

    public function test_creating_customer_with_empty_first_name_returns_error()
    {
        $data = [
            'first_name' => '',
            'last_name' => $this->faker->lastName(),
        ];

        $pathToTest = route('customers.create');
        $response = $this->post($pathToTest, $data);

        $response->assertSessionHasErrors();
    }

    public function test_creating_customer_with_empty_last_name_returns_error()
    {
        $data = [
            'first_name' => $this->faker->firstName(),
            'last_name' => '',
        ];

        $pathToTest = route('customers.create');
        $response = $this->post($pathToTest, $data);

        $response->assertSessionHasErrors();
    }
}
