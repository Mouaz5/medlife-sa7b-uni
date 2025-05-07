<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
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
            'exam_content' => $this->faker->paragraph,
            'solution_content' => $this->faker->paragraph,
            'course_id' => Course::inRandomOrder()->value('id'),
            'academic_year_id' => AcademicYear::inRandomOrder()->value('id'),
        ];
    }
}
