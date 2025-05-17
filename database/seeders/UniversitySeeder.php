<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $universities = [
            'Damascus University',
            'Syrian Private University',
            'Syrian Virtual University',
            'Higher Institute of Business Administration',
            'Higher Institute of Applied Sciences and Technology',
            'Al Rasheed International Private University for Science and Technology',
            'Al-Sham Private University',
            'Bilad Al Sham University',
            'Qasyoun University for Science and Technology',
            'Yarmouk Private University',
            'International University for Science and Technology',
            'Al Jazeera University',
            'Arab International University',
            'National Institute for Public Administration',
            'Higher Institute of Dramatic Arts',
            'Higher Institute of Music'
        ];

        $records = array_map(function ($name) {
            return ['name' => $name, 'created_at' => now(), 'updated_at' => now()];
        }, $universities);

        DB::table('universities')->insert($records);
    }
}
