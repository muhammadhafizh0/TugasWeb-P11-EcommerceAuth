<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 60 produk realistis (memenuhi requirement 50+ produk)
        Product::factory()->count(60)->create();
    }
}
