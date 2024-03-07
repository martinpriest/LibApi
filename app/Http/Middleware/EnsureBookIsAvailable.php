<?php

namespace App\Http\Middleware;

use App\Models\Book;
use Closure;
use Illuminate\Http\Request;

class EnsureBookIsAvailable
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var Book $book */
        $book = $request?->book ?? null;
        if (! $book || ! $book->isAvailable()) {
            return response(['message' => __('books.not_available')], 404);
        }

        return $next($request);
    }
}
