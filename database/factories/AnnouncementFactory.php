<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Student;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcements>
 */
class AnnouncementFactory extends Factory
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
            'content' => $this->faker->paragraph,
            'course_id' => Course::inRandomOrder()->value('id'),
            'topic_id' => Topic::inRandomOrder()->value('id'),
            'author_id' => Student::inRandomOrder()->value('id'),
            'published_at' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'expires_at' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
        ];
    }
}
