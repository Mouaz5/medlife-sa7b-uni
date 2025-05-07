<?php

namespace Database\Seeders;

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

        User::factory()->create([
            'username' => 'test_user',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        \App\Models\University::factory(20)->create();
        \App\Models\Collage::factory(20)->create();
        \App\Models\Topic::factory(20)->create();
        \App\Models\AcademicYear::factory(20)->create();
        \App\Models\StudyYear::factory(20)->create();
        \App\Models\Semester::factory(20)->create();
        \App\Models\Course::factory(20)->create();
        \App\Models\CourseEvent::factory(20)->create();
        \App\Models\Lecture::factory(20)->create();
        \App\Models\LectureAudio::factory(20)->create();
        \App\Models\Exam::factory(20)->create();
        \App\Models\Specialization::factory(20)->create();
        \App\Models\Student::factory(20)->create();
        \App\Models\StudentCourse::factory(20)->create();
        \App\Models\StudentAcademicTimeline::factory(20)->create();
        \App\Models\Skill::factory(20)->create();
        \App\Models\Post::factory(20)->create();
        \App\Models\PostFile::factory(20)->create();
        \App\Models\Complaint::factory(20)->create();
        \App\Models\ComplaintFile::factory(20)->create();
        \App\Models\Certificate::factory(20)->create();
        \App\Models\Follow::factory(20)->create();
        \App\Models\Feedback::factory(20)->create();
        \App\Models\FeedbackQuestion::factory(20)->create();
        \App\Models\FeedbackAnswer::factory(20)->create();
        \App\Models\PrivacySetting::factory(20)->create();
        \App\Models\Handout::factory(20)->create();
        \App\Models\Announcement::factory(20)->create();
        \App\Models\AcademicGuidance::factory(20)->create();
        \App\Models\AcademicGuidanceVote::factory(20)->create();
    }
}
