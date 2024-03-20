<?php

namespace Database\Factories;

use App\Models\Benefit;
use App\Models\MaximumAmount;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaximumAmount>
 */
class MaximumAmountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $benefit = Benefit::pluck('id')->all();

        return [
            'id_beneficio' => $this->faker->unique(true)->randomElement($benefit),
            'monto_minimo' => $this->faker->numberBetween(0, 1000),
            'monto_maximo' => $this->faker->numberBetween(1000, 10000),
        ];
    }
}
