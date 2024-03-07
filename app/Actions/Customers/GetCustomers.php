<?php

namespace App\Actions\Customers;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetCustomers
{
    use AsAction;

    public function handle(): Collection
    {
        return Customer::all();
    }

    public function asController()
    {
        $customers = $this->handle();

        return response($customers);
    }
}
