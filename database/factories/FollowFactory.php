<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Follow;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'follower_id' => Student::factory(),
            'followed_id' => Student::factory(),
        ];
    }

    /**
     * Configure the factory to ensure unique follower-followed pairs
     */
    public function configure()
    {
        return $this->afterMaking(function (Follow $follow) {
            // Ensure follower and followed are different students
            if ($follow->follower_id === $follow->followed_id) {
                $follow->followed_id = Student::where('id', '!=', $follow->follower_id)
                    ->inRandomOrder()
                    ->value('id');
            }
        });
    }
}
