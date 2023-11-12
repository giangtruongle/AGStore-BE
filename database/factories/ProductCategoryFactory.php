<?php

namespace Database\Factories;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductCategory>
 */
class ProductCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name;
        $slug = Str::slug($name);
        return [
            'name' => $name,
            'slug' => $slug,
            'status' => fake()->numberBetween(0, 1),
            'image_url_pc' => asset('http://127.0.0.1:8000/images/default_image.jpg')
        ];
    }
}
