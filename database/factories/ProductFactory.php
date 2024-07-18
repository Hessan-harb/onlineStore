<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
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
        $name=$this->faker->word(5,true);
        return [
            'name'=>$name,
            'slug'=>Str::slug($name),
             'description'=>$this->faker->sentence(5),
             'image'=>$this->faker->imageUrl(800,800),
             'price'=>$this->faker->randomDigit(1,1,999),
             'compare_price'=>$this->faker->randomDigit(1,500,999),
             'category_id'=>Category::inRandomOrder()->first()->id,
             'featured'=>rand(0,1),
             'store_id'=>Store::inRandomOrder()->first()->id,
        ];
    }
}
