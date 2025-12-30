<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\StudyProgram;
use App\Models\User;
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
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'stock' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->randomElement(['draft', 'pending_verif', 'verified', 'rejected']),
            'seller_id' => User::factory(),
            'category_id' => Category::factory(),
            'prodi_id' => StudyProgram::factory(),
        ];
    }
}
