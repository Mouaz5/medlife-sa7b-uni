<?php

namespace Database\Factories;

use App\Models\Complaint;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ComplaintFile>
 */
class ComplaintFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => $this->faker->image,
            'complaint_id' => Complaint::inRandomOrder()->value('id'),
        ];
    }
}
