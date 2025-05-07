<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\academicYear>
 */
class AcademicYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
    	$years = [2015, 2016, 2017, 2020, 2021, 2022, 2023, 2024, 2025, 2026];
        return [
            'year' => $years[$this->faker->numberBetween(0, count($years) - 1)],
        ];
    }
}
