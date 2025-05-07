<?php

namespace Database\Factories;

use App\Models\Feedback;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FeedbackQuestion>
 */
class FeedbackQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question_text' => $this->faker->sentence,
            'student_id' => Student::inRandomOrder()->value('id'),
            'feedback_id' => Feedback::inRandomOrder()->value('id'),
        ];
    }
}
