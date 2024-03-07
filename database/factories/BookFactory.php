<?php

namespace Database\Factories;

use App\Enums\BookStatus;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->realText(64),
            'author' => $this->faker->name(),
            'publication_date' => $this->faker->date(),
            'publishing_house' => $this->faker->company(),
            'status' => $this->faker->randomElement([BookStatus::AVAILABLE->value, BookStatus::NOT_AVAILABLE->value]),
            'customer_id' => null,
        ];
    }

    public function available()
    {
        return $this->state(
            fn () => [
                'status' => BookStatus::AVAILABLE->value,
                'customer_id' => null,
            ]
        );
    }

    public function notAvailable()
    {
        return $this->state(
            fn () => [
                'status' => BookStatus::NOT_AVAILABLE->value,
            ]
        );
    }

    public function borrowed()
    {
        return $this->state(
            fn () => [
                'status' => BookStatus::BORROWED->value,
                'customer_id' => Customer::factory(),
            ]
        );
    }

    public function borrowedBy(int $customerId)
    {
        return $this->state(
            fn () => [
                'status' => BookStatus::BORROWED->value,
                'customer_id' => $customerId,
            ]
        );
    }
}
