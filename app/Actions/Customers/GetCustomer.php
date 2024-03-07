<?php

namespace App\Actions\Customers;

use App\Models\Customer;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCustomer
{
    use AsAction;

    public function handle(Customer $customer): Customer
    {
        $customer->load(['books']);

        return $customer;
    }

    public function asController(Customer $customer)
    {
        $customerWithBooks = $this->handle($customer);

        return response($customerWithBooks);
    }
}
