<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'payment_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'payment_method' => $this->faker->randomElement(['Bank Transfer', 'Credit Card', 'Cash', 'Online']),
            'transaction_reference' => strtoupper($this->faker->bothify('TXN-########')),
            'notes' => $this->faker->sentence(),
        ];
    }
}
