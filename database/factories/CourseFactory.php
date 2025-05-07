<?php

namespace Database\Factories;

use App\Models\Collage;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'collage_id' => Collage::inRandomOrder()->value('id'),
            'semester_id' => Semester::inRandomOrder()->value('id'),
        ];
    }
}
