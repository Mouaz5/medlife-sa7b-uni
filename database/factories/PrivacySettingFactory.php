<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrivacySetting>
 */
class PrivacySettingFactory extends Factory
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
            'show_posts' => $this->faker->boolean,
            'profile_visibility' => $this->faker->randomElement(['public', 'private']),
        ];
    }
}
