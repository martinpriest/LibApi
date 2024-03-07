## Description
    Simple Library API project based on Laravel framework.

------------------------------------------------------------------------------------------
## Search books
 <summary><code>GET</code> <code><b>/api/books</b></code> <code>Get paginated list of books.</code></summary>

##### Parameters

> | name      | required  | description                                               |
> |-----------|-----------|-----------------------------------------------------------|
> | per_page  | false     | Records per page. Default value: 20. Example: ?per_page=5
> | page      | false     | Returned page. Example: ?page=1
> | title     | false     | Filter records by title. Example: ?title=Harry
> | author    | false     | Filter records by author. Example: ?author=JK
> | customer  | false     | Filter records by customer. Example: ?customer=Kowalski


------------------------------------------------------------------------------------------
## Book details
 <summary><code>GET</code> <code><b>/api/books/{book_id}</b></code> <code>Get book details.</code></summary>

------------------------------------------------------------------------------------------
## Customer list
 <summary><code>GET</code> <code><b>/api/customers</b></code> <code>Get all customers.</code></summary>

------------------------------------------------------------------------------------------
## Customer details
 <summary><code>GET</code> <code><b>/api/customers/{customer_id}</b></code> <code>Get customer details.</code></summary>

------------------------------------------------------------------------------------------
## Create customer
 <summary><code>POST</code> <code><b>/api/customers</b></code> <code>Create new customer.</code></summary>
 
##### Parameters

> | name       | required  | description                                               |
> |------------|-----------|-----------------------------------------------------------|
> | first_name | true      | Customer first name. Example: John
> | last_name  | true      | Customer lastname. Example: Smith


------------------------------------------------------------------------------------------
## Delete customer
 <summary><code>DELETE</code> <code><b>/api/customers/{customer_id}</b></code> <code>Delete customer by ID.</code></summary>

------------------------------------------------------------------------------------------
## Borrow book by customer
 <summary><code>PUT</code> <code><b>/api/books/{book_id}/borrow/{customer_id}</b></code> <code>Borrow book by customer.</code></summary>
 
------------------------------------------------------------------------------------------
## Return book by customer
 <summary><code>PUT</code> <code><b>/api/books/{book_id}/return/{customer_id}</b></code> <code>Return book by customer.</code></summary>
------------------------------------------------------------------------------------------


## Run project
- sudo service mysql start
- login into MySQL user, create database and update setup in .env file
- composer install
- php artisan migrate
- php artisan serve

## Run tests
- sudo service mysql start
- login into MySQL user, create database and update setup in .env file
- composer install
- php artisan tests

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
