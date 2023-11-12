<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use App\Models\ProductCategory;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
        $arrayCategoryIds = ProductCategory::all()->pluck('id');
        $productCategoryId = fake()->randomElement($arrayCategoryIds);
            return [
                'name' => $name,
                'slug' => $slug,
                'price' => fake()->numberBetween(10, 1000),
                'original_price' => fake()->numberBetween(10, 1000),
                'description' => fake()->text,
                'quantity' => fake()->numberBetween(10,100),
                'size'=>fake()->text,
                'status' => fake()->numberBetween(0,1),
                'product_category_id' => $productCategoryId,
                'image_url' => asset('http://127.0.0.1:8000/images/default_image.jpg')
            ];
    }
}
