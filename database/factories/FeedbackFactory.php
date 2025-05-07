<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
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
            'date' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'course_id' => Course::inRandomOrder()->value('id'),
            'author_id' => Student::inRandomOrder()->value('id'),
            'type' => $this->faker->randomElement(['positive', 'negative']),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
