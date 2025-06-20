<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Author;
use App\Models\Project;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        $authors = Author::factory(15)
            ->create()
            ->concat(
                Author::factory(5)
                    ->withoutUser()
                    ->create()
            );

        Project::factory(30)
            ->create()
            ->each(function ($project) use ($authors) {
                $project->authors()->attach(
                    $authors->random(rand(1, 3))->pluck('id')
                );
            });
    }
}
