<?php

namespace Database\Factories;

use App\Models\Inspection;
use App\Models\InspectionItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InspectionItem>
 */
class InspectionItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'inspection_id' => Inspection::factory(),
            'section' => 'Exterior & Body',
            'item_key' => 'exterior_paint',
            'label' => 'Paint condition — all panels',
            'score' => 8,
            'photo' => 'pdi/exterior-paint.jpg',
        ];
    }
}
