<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name();
        $status = rand(0, 1);
        $slug = Str::slug($name); // Generate a slug from the name

        // Check if the generated slug already exists in the database
        // If it does, append a number to make it unique
        $i = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = Str::slug($name) . '-' . $i;
            $i++;
        }

        return [
            'name' => $name,
            'status' => $status,
            'slug' => $slug
        ];
    }
}
