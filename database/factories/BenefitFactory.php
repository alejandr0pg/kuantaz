<?php

namespace Database\Factories;

use App\Models\Benefit;
use App\Models\Record;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Benefit>
 */
class BenefitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $records = Record::pluck('id')->all();

        return [
            'nombre' => $this->faker->name(),
            'id_ficha' => $this->faker->unique()->randomElement($records),
            'fecha' => $this->faker->date('Y-m-d', 'now'),
        ];
    }
}
