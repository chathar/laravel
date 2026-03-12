<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = $this->faker->dateTimeBetween('-1 year', 'now');
        $dueDate = (clone $date)->modify('+14 days');

        return [
            'invoice_number' => 'INV-' . strtoupper($this->faker->bothify('??###')),
            'client_id' => Client::factory(),
            'invoice_date' => $date,
            'due_date' => $dueDate,
            'status' => $this->faker->randomElement(['draft', 'sent', 'paid', 'overdue', 'cancelled', 'partially_paid']),
            'subtotal' => 0,
            'tax_rate' => 10,
            'tax_amount' => 0,
            'discount_amount' => 0,
            'total' => 0,
            'notes' => $this->faker->sentence(),
        ];
    }
}
