<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Lecture;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LectureAudio>
 */
class LectureAudioFactory extends Factory
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
            'content' => $this->faker->word(6) . '.mp3',
            'lecture_id' => Lecture::inRandomOrder()->value('id'),
            'academic_year_id' => AcademicYear::inRandomOrder()->value('id'),
        ];
    }
}
