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
        $users = User::factory()->count(10)->create();

        $projects = Project::factory()->count(15)->create();

        $projects->each(function ($project) use ($users) {
            $selectedUsers = $users->random(2);

            $selectedUsers->each(function ($user) use ($project) {
                Author::create([
                    'user_id' => $user->id,
                    'project_id' => $project->id,
                    'name' => $user->name
                ]);
            });
        });

    }
}
