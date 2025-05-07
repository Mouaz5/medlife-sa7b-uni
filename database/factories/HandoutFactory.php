<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Handouts>
 */
class HandoutFactory extends Factory
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
            'content' => $this->faker->text,
            'course_id' => Course::inRandomOrder()->value('id'),
            'academic_year_id' => AcademicYear::inRandomOrder()->value('id'),
            'student_id' => Student::inRandomOrder()->value('id'),
        ];
    }
}
