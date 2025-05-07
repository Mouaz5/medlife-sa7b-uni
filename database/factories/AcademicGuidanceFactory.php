<?php

namespace Database\Factories;

use App\Models\AcademicGuidance;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcademicGuidance>
 */
class AcademicGuidanceFactory extends Factory
{
    protected $model = AcademicGuidance::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['up', 'down']),
            'course_id' => Course::inRandomOrder()->value('id'),
            'student_id' => Student::inRandomOrder()->value('id'),
            'vote_count' => $this->faker->randomNumber(2),
        ];
    }
}
