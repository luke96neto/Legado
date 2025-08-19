<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    public function definition()
    {
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraphs(3, true),
            'status' => fake()->randomElement(['rascunho', 'em_andamento', 'concluido']),
            'user_id' => User::factory(),
            'repo_url' => fake()->optional()->url(),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'rascunho',
        ]);
    }

    public function published(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'publicado',
        ]);
    }
}
