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
        $collages = DB::table('colleges')->pluck('id')->toArray();

        $studyYears = [];
        foreach ($collages as $collageId) {
            $studyYears = array_merge($studyYears, [
                ['year' => 'first', 'collage_id' => $collageId, 'created_at' => now(), 'updated_at' => now()],
                ['year' => 'second', 'collage_id' => $collageId, 'created_at' => now(), 'updated_at' => now()],
                ['year' => 'third', 'collage_id' => $collageId, 'created_at' => now(), 'updated_at' => now()],
                ['year' => 'fourth', 'collage_id' => $collageId, 'created_at' => now(), 'updated_at' => now()],
                ['year' => 'fifth', 'collage_id' => $collageId, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        DB::table('study_years')->insert($studyYears);
    }
}
