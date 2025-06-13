<?php

namespace Database\Seeders;

use App\Models\StudyYear;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::where('email', 'test@example.com')->delete();

        User::factory()->create([
            'username' => 'test_user',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->call(UniversitySeeder::class);
        $this->call(CollegeSeeder::class);
        $this->call(StudyYearSeeder::class);
        \App\Models\Topic::factory(10)->create();
        \App\Models\AcademicYear::factory(10)->create();
        \App\Models\Semester::factory(10)->create();
        \App\Models\Course::factory(10)->create();
        \App\Models\CourseEvent::factory(10)->create();
        \App\Models\Lecture::factory(10)->create();
        \App\Models\LectureAudio::factory(10)->create();
        \App\Models\Exam::factory(10)->create();
        \App\Models\Specialization::factory(10)->create();
        \App\Models\Student::factory(10)->create();
        \App\Models\StudentCourse::factory(10)->create();
        \App\Models\StudentAcademicTimeline::factory(10)->create();
        \App\Models\Skill::factory(10)->create();
        \App\Models\Post::factory(10)->create();
        \App\Models\PostFile::factory(10)->create();
        \App\Models\ComplaintType::factory(10)->create();
        \App\Models\Complaint::factory(10)->create();
        \App\Models\ComplaintFile::factory(10)->create();
        \App\Models\Certificate::factory(10)->create();
        \App\Models\Follow::factory(10)->create();
        \App\Models\Feedback::factory(10)->create();
        \App\Models\FeedbackQuestion::factory(10)->create();
        \App\Models\FeedbackAnswer::factory(10)->create();
        \App\Models\PrivacySetting::factory(10)->create();
        \App\Models\Handout::factory(10)->create();
        \App\Models\Announcement::factory(10)->create();
        \App\Models\AcademicGuidance::factory(10)->create();
        \App\Models\AcademicGuidanceVote::factory(10)->create();
        \App\Models\Semester::factory(10)->create();
        \App\Models\AcademicYear::factory(10)->create();
    }
}
