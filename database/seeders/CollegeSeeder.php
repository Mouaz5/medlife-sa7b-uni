<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $universities = DB::table('universities')->pluck('id', 'name')->toArray();

        $colleges = [
            ['name' => 'Faculty of Medicine', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Dentistry', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Pharmacy', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Engineering', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Law', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Arts and Humanities', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Science', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Agriculture', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Economics', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Education', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Islamic Studies', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Political Science', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Fine Arts', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Architecture', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Civil Engineering', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Mechanical and Electrical Engineering', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Information Technology', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Nursing', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Physical Education', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Tourism', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Media', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Veterinary Medicine', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Health Sciences', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Environmental Sciences', 'university_id' => $universities['Damascus University']],
            ['name' => 'Faculty of Social Sciences', 'university_id' => $universities['Damascus University']],

            // Syrian Private University
            ['name' => 'Faculty of Medicine', 'university_id' => $universities['Syrian Private University']],
            ['name' => 'Faculty of Dentistry', 'university_id' => $universities['Syrian Private University']],
            ['name' => 'Faculty of Pharmacy', 'university_id' => $universities['Syrian Private University']],
            ['name' => 'Faculty of Business Administration', 'university_id' => $universities['Syrian Private University']],
            ['name' => 'Faculty of Information Technology', 'university_id' => $universities['Syrian Private University']],
            ['name' => 'Faculty of Petroleum Engineering', 'university_id' => $universities['Syrian Private University']],

            // Syrian Virtual University
            ['name' => 'Faculty of Informatics and Communications', 'university_id' => $universities['Syrian Virtual University']],
            ['name' => 'Faculty of Administrative Sciences', 'university_id' => $universities['Syrian Virtual University']],
            ['name' => 'Faculty of Humanities', 'university_id' => $universities['Syrian Virtual University']],
            ['name' => 'Faculty of Law', 'university_id' => $universities['Syrian Virtual University']],
            ['name' => 'Faculty of Media and Communication', 'university_id' => $universities['Syrian Virtual University']],
            ['name' => 'Faculty of Educational Sciences', 'university_id' => $universities['Syrian Virtual University']],

            // Higher Institute of Business Administration (HIBA)
            ['name' => 'Faculty of Business Administration', 'university_id' => $universities['Higher Institute of Business Administration']],

            // Higher Institute of Applied Sciences and Technology (HIAST)
            ['name' => 'Faculty of Telecommunications Engineering', 'university_id' => $universities['Higher Institute of Applied Sciences and Technology']],
            ['name' => 'Faculty of Electronics Engineering', 'university_id' => $universities['Higher Institute of Applied Sciences and Technology']],
            ['name' => 'Faculty of Mechatronics Engineering', 'university_id' => $universities['Higher Institute of Applied Sciences and Technology']],
            ['name' => 'Faculty of Informatics Engineering', 'university_id' => $universities['Higher Institute of Applied Sciences and Technology']],
            ['name' => 'Faculty of Materials Engineering', 'university_id' => $universities['Higher Institute of Applied Sciences and Technology']],
            ['name' => 'Faculty of Aeronautical Engineering', 'university_id' => $universities['Higher Institute of Applied Sciences and Technology']],
        ];

        $records = array_map(function ($college) {
            return array_merge($college, ['created_at' => now(), 'updated_at' => now()]);
        }, $colleges);

        DB::table('colleges')->insert($records);
    }
}
