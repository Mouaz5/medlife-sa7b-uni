<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StudyYear;
use App\Models\Student;
use App\Models\Specialization;
use App\Models\AcademicYear;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentAcademicTimeline>
 */
class StudentAcademicTimelineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'study_year_id' => StudyYear::inRandomOrder()->value('id'),
            'student_id' => Student::inRandomOrder()->value('id'),
            'specialization_id' => Specialization::inRandomOrder()->value('id'),
            'academic_year_id' => AcademicYear::inRandomOrder()->value('id'),
        ];
    }
}
