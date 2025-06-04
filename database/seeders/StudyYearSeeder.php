<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudyYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $colleges = DB::table('colleges')->pluck('id')->toArray();

        $studyYears = [];
        foreach ($colleges as $collegeId) {
            $studyYears = array_merge($studyYears, [
                ['year' => 'first', 'college_id' => $collegeId, 'created_at' => now(), 'updated_at' => now()],
                ['year' => 'second', 'college_id' => $collegeId, 'created_at' => now(), 'updated_at' => now()],
                ['year' => 'third', 'college_id' => $collegeId, 'created_at' => now(), 'updated_at' => now()],
                ['year' => 'fourth', 'college_id' => $collegeId, 'created_at' => now(), 'updated_at' => now()],
                ['year' => 'fifth', 'college_id' => $collegeId, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        DB::table('study_years')->insert($studyYears);
    }
}
