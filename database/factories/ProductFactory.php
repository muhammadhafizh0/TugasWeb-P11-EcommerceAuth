<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $adjectives = ['Premium', 'Original', 'Best Seller', 'Limited Edition', 'Basic', 'Pro'];
        $nouns = [
            'Kemeja', 'Sepatu Sneakers', 'Tas Ransel', 'Headset Bluetooth', 'Smartwatch',
            'Blender', 'Rice Cooker', 'Matras Yoga', 'Botol Minum', 'Kaos Polos',
            'Jaket Hoodie', 'Powerbank', 'Charger USB-C', 'Meja Lipat', 'Kursi Gaming',
        ];

        $name = $this->faker->randomElement($adjectives) . ' ' . $this->faker->randomElement($nouns)
            . ' ' . $this->faker->numberBetween(1, 999);

        return [
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'name'        => $name,
            'slug'        => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1000, 999999),
            'description' => $this->faker->paragraph(3),
            'price'       => $this->faker->numberBetween(15, 2500) * 1000, // Rp15.000 - Rp2.500.000
            'stock'       => $this->faker->numberBetween(0, 200),
        ];
    }
}
