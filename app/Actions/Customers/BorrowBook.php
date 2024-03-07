<?php

namespace App\Actions\Customers;

use App\Enums\BookStatus;
use App\Models\Book;
use App\Models\Customer;
use Lorisleiva\Actions\Concerns\AsAction;

class BorrowBook
{
    use AsAction;

    public function getControllerMiddleware()
    {
        return ['book_is_available'];
    }

    public function handle(Customer $customer, Book $book): bool
    {
        // TODO: thinking about move to Book model, and there check if book is available instead of in middleware
        $book->customer_id = $customer->id;
        $book->status = BookStatus::BORROWED;

        return $book->save();
    }

    public function asController(Customer $customer, Book $book)
    {
        if ($this->handle($customer, $book)) {
            return response(['message' => __('customers.borrow_successfull')]);
        }

        return response(['message' => __('errors.common.something_went_wrong')]);
    }
}
