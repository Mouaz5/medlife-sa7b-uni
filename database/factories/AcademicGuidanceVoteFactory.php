<?php

namespace Database\Factories;

use App\Models\AcademicGuidance;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcademicGuidanceVote>
 */
class AcademicGuidanceVoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->value('id'),
            'academic_guidance_id' => AcademicGuidance::inRandomOrder()->value('id'),
            'type' => $this->faker->randomElement(['up', 'down']),
        ];
    }
}
