<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseEvent>
 */
class CourseEventFactory extends Factory
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
            'description' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['exam', 'quiz', 'assignment']),
            'session_type' => $this->faker->randomElement(['online', 'offline']),
            'start_date' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'end_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'course_id' => Course::inRandomOrder()->value('id'),
        ];
    }
}
