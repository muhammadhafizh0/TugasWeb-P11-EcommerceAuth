<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'Elektronik', 'Fashion Pria', 'Fashion Wanita', 'Peralatan Rumah Tangga',
            'Olahraga', 'Kesehatan & Kecantikan', 'Buku & Alat Tulis', 'Otomotif',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
