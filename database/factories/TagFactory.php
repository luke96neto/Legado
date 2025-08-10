<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $colors = ['#a995c9', '#f2b8c6', '#77b8a1', '#f0c88d', '#a0bbe3'];
    protected $tags = ['javascript','java','php','python','vue','inertia','laravel','typescript'];
    public function definition(): array
    {
        static $usedTags = [];
        
        if (count($usedTags) >= count($this->tags)) {
            $baseTag = $this->faker->randomElement($this->tags);
            $tagName = $baseTag . '_' . (count($usedTags) - count($this->tags) + 1);
        } else {
            do {
                $tagName = $this->faker->randomElement($this->tags);
            } while (in_array($tagName, $usedTags));
            
            $usedTags[] = $tagName;
        }
        
        return [
            
            'name' => $tagName,
            'color' => $this->faker->randomElement($this->colors),
        ];
    }
    
    public function laravel()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Laravel',
                'color' => '#ff2d20',
            ];
        });
    }
}
