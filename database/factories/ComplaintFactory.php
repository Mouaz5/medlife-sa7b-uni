<?php

namespace Database\Factories;

use App\Models\ComplaintType;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Complaint>
 */
class ComplaintFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'type_id' => ComplaintType::inRandomOrder()->value('id'),
            'description' => $this->faker->sentence,
            'student_id' => Student::inRandomOrder()->value('id'),
        ];
    }
}
