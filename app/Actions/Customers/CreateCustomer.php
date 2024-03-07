<?php

namespace App\Actions\Customers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateCustomer
{
    use AsAction;

    public function handle(array $data): Customer
    {
        $customer = Customer::create($data);

        return $customer;
    }

    public function asController(CustomerRequest $request)
    {
        $data = $request->validated();
        $customer = $this->handle($data);

        return response(['message' => __('customer.created'), 'customer' => $customer]);
    }
}
