<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Author;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Feedback;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory(10)->create();
        
        $authors = Author::factory(10)
            ->create()
            ->concat(
                Author::factory(5)
                    ->withoutUser()
                    ->create()
            );

        $tags = Tag::factory(8)->create();
        
        $projects = Project::factory(30)
            ->create()
            ->each(function ($project) use ($authors, $tags) {
                $project->authors()->attach(
                    $authors->random(rand(1, 3))->pluck('id')
                );
                
                $project->tags()->attach(
                    $tags->random(rand(1, 4))->pluck('id')
                );
            });

        $projects->each(function ($project) use ($users) {
            Comment::factory(rand(2, 5))
                ->create([
                    'project_id' => $project->id,
                    'user_id' => $users->random()->id
                ]);
        });

        $projects->each(function ($project) use ($users) {
            Feedback::factory(rand(3, 10))
                ->create([
                    'project_id' => $project->id,
                    'user_id' => $users->random()->id
                ]);
        });
    }
}