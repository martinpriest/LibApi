<?php

use App\Actions\Books\BorrowBook;
use App\Actions\Books\GetBook;
use App\Actions\Books\GetBooks;
use App\Actions\Books\ReturnBook;
use App\Actions\Customers\CreateCustomer;
use App\Actions\Customers\DeleteCustomer;
use App\Actions\Customers\GetCustomer;
use App\Actions\Customers\GetCustomers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/customers')->name('customers.')->group(function () {
    Route::get('/', GetCustomers::class)->name('find.all');
    Route::get('/{customer}', GetCustomer::class)->name('find.one');
    Route::post('/', CreateCustomer::class)->name('create');
    Route::delete('/{customer}', DeleteCustomer::class)->name('delete');
});

Route::prefix('/books')->name('books.')->group(function () {
    Route::get('/', GetBooks::class)->name('find.all');
    Route::get('/{book}', GetBook::class)->name('find.one');
    Route::put('/{book}/borrow/{customer}', BorrowBook::class)->name('update.borrow');
    Route::put('/{book}/return/{customer}', ReturnBook::class)->name('update.return');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
