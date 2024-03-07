<?php

namespace App\Actions\Customers;

use App\Models\Customer;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteCustomer
{
    use AsAction;

    public function getControllerMiddleware()
    {
        return ['customer_has_not_borrowed_books'];
    }

    public function handle(Customer $customer): bool
    {
        return $customer->delete();
    }

    public function asController(Customer $customer)
    {
        if ($this->handle($customer)) {
            return response(['message' => __('customer.deleted')]);
        } else {
            return response(['message' => __('errors.common.something_went_wrong')]);
        }
    }
}
