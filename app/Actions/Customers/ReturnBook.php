<?php

namespace App\Actions\Customers;

use App\Enums\BookStatus;
use App\Models\Book;
use App\Models\Customer;
use Lorisleiva\Actions\Concerns\AsAction;

class ReturnBook
{
    use AsAction;

    public function getControllerMiddleware()
    {
        return ['customer_is_book_owner'];
    }

    public function handle(Book $book): bool
    {
        $book->customer_id = null;
        $book->status = BookStatus::AVAILABLE;

        return $book->save();
    }

    public function asController(Customer $customer, Book $book)
    {
        if ($this->handle($book)) {
            return response(['message' => __('customers.return_successfull')]);
        }

        return response(['message' => __('errors.common.something_went_wrong')]);
    }
}
