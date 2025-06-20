<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => fn() => User::factory()->create()->id,
            'name' => fake()->name(),
            'slug' => fake()->unique()->slug(),
            'bio' => fake()->paragraph(),
        ];
    }

    public function withoutUser(): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => null,
        ]);
    }
}