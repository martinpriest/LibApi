<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Customer::factory(10)->create();
        Book::factory(50)->create();
        Book::factory(5)->notAvailable()->create();
        Book::factory(5)->borrowed()->create();
    }
}
