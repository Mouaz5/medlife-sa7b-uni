<?php

namespace Database\Factories;

use App\Models\FeedbackQuestion;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FeedbackAnswer>
 */
class FeedbackAnswerFactory extends Factory
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
            'feedback_question_id' => FeedbackQuestion::inRandomOrder()->value('id'),
            'answer_text' => $this->faker->sentence(10),
        ];
    }
}
