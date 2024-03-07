<?php

namespace App\Http\Middleware;

use App\Models\Customer;
use Closure;
use Illuminate\Http\Request;

class EnsureCustomerHasNoBorrowedBooks
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
        if (! $customer || $customer->books->count() > 0) {
            return response(['message' => __('customer.customer_has_borrowed_books')], 404);
        }

        return $next($request);
    }
}
