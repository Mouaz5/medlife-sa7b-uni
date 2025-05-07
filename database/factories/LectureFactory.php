<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lecture>
 */
class LectureFactory extends Factory
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
            'content' => $this->faker->word(6) . '.pdf',
            'course_id' => Course::inRandomOrder()->value('id'),
            'academic_year_id' => AcademicYear::inRandomOrder()->value('id'),
        ];
    }
}
