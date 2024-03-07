<?php

namespace App\Actions\Books;

use App\Models\Book;
use App\Models\Customer;
use Lorisleiva\Actions\Concerns\AsAction;

class ReturnBook
{
    use AsAction;

    public function handle(Book $book, Customer $customer): bool
    {
        return $book->returnBy($customer);
    }

    public function asController(Book $book, Customer $customer)
    {
        if ($this->handle($book, $customer)) {
            return response(['message' => __('customers.return_successfull')]);
        }

        return response(['message' => __('errors.common.something_went_wrong')], 404);
    }
}
