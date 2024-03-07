<?php

namespace App\Http\Middleware;

use App\Models\Book;
use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;

class EnsureCustomerIsBookOwner
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var Customer $customer */
        $customer = $request?->customer ?? null;
        /** @var Book $book */
        $book = $request?->book ?? null;
        if (! $book || ! $customer) {
            return response(['message' => __('errors.common.something_went_wrong')], 404);
        }

        if ($book->customer_id !== $customer->id) {
            return response(['message' => __('customers.no_book_permission')], 404);
        }

        return $next($request);
    }
}
