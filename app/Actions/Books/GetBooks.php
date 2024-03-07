<?php

namespace App\Actions\Books;

use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class GetBooks
{
    use AsAction;

    public function handle(Collection $filters, Collection $pagination): LengthAwarePaginator
    {
        $query = Book::select('books.status', 'books.title', 'books.author', 'customers.first_name', 'customers.last_name')
            ->leftJoin('customers', 'customers.id', '=', 'books.customer_id')
            // TODO: thinking about index on title and author DB column
            ->when(
                $filters->get('title'),
                fn ($query, $title) => $query->where('books.title', 'like', "%$title%")
            )
            ->when(
                $filters->get('author'),
                fn ($query, $author) => $query->where('books.author', 'like', "%$author%")
            )
            ->when(
                $filters->get('customer'),
                fn ($query, $customer) => $query
                    ->where('customers.first_name', 'like', "%$customer%")
                    ->orWhere('customers.last_name', 'like', "%$customer%"),
            );

        $page = $query->paginate(
            perPage: (int) $pagination->get('per_page', 20),
            page: (int) $pagination->get('page', 1),
        );

        return $page;
    }

    public function asController(ActionRequest $request)
    {
        $paginationParams = ['per_page', 'page'];
        $pagination = collect($request->only($paginationParams));
        $filters = collect($request->except($paginationParams));
        $booksPage = $this->handle($filters, $pagination);

        return response($booksPage);
    }
}
