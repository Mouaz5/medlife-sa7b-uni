<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Specialization>
 */
class SpecializationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specializations = [
            'ذكاء صنعي', 'برمجيات', 'شبكات', 'اتصالات', 'نظم معلومات', 'رياضيات',
            'تعلم الألة', 'Big data', 'LLM', 'عام'
        ];
        return [
            'name' => $specializations[$this->faker->numberBetween(0, count($specializations) - 1)],
        ];
    }
}
