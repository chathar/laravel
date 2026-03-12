<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $qty = $this->faker->numberBetween(1, 10);
        $price = $this->faker->randomFloat(2, 50, 500);

        return [
            'invoice_id' => Invoice::factory(),
            'description' => $this->faker->words(3, true),
            'quantity' => $qty,
            'unit_price' => $price,
            'total' => $qty * $price,
        ];
    }
}
