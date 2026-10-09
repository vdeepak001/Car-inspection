<?php

namespace Database\Factories;

use App\Models\Inspection;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inspection>
 */
class InspectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'brand' => 'DS Automobiles',
            'model_name' => 'DS 7',
            'location' => 'Nagpur',
            'inspector' => fake()->name(),
            'vin' => fake()->bothify('TM5###########'),
            'engine_number' => fake()->bothify('ENG#####'),
            'inspected_on' => '2026-08-09',
            'overall_rating' => 7.4,
            'status' => 'completed',
            'photos' => [],
        ];
    }
}
