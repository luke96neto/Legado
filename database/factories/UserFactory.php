<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nickname' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'google_id' => fake()->optional()->numerify('###########'),
            'google_token' => fake()->optional()->md5(),
            'google_refresh_token' => fake()->optional()->md5(),
            'github_id' => fake()->optional()->numerify('###########'),
            'github_token' => fake()->optional()->md5(),
            'github_refresh_token' => fake()->optional()->md5(),
            'email_verified_at' => now()
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
