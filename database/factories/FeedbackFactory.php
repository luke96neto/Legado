<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    public function definition(): array
    {
        return [
            'rating' => $this->faker->numberBetween(0, 5),
            'project_id' => Project::factory(),
            'user_id' => User::factory(),
        ];
    }

    public function positive()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => $this->faker->numberBetween(4, 5),
            ];
        });
    }

    public function negative()
    {
        return $this->state(function (array $attributes) {
            return [
                'rating' => $this->faker->numberBetween(0, 2),
            ];
        });
    }
}
