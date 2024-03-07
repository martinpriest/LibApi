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
        try {
            $this->handle($book, $customer);

            return response(['message' => __('books.return_successfull')]);
        } catch (\App\Exceptions\CustomerIsNotBookOwnerException) {
            return response(['message' => __('customers.no_book_permission')], 404);
        } catch (\Exception) {
            return response(['message' => __('errors.common.something_went_wrong')], 404);
        }
    }
}
