<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $beer = Category::where('name', 'Beer')->first();
        $spirits = Category::where('name', 'Spirits')->first();
        $soft = Category::where('name', 'Soft Drinks')->first();
        $energy = Category::where('name', 'Energy Drinks')->first();

        // Beer
        Product::create([
            'name' => 'Safari Lager 500ml',
            'category_id' => $beer->id,
            'buy_price' => 1800,
            'sell_price' => 2500,
            'stock_qty' => 0,
            'unit' => 'bottle',
        ]);

        Product::create([
            'name' => 'Kilimanjaro Lager 500ml',
            'category_id' => $beer->id,
            'buy_price' => 1700,
            'sell_price' => 2400,
            'stock_qty' => 0,
            'unit' => 'bottle',
        ]);

        // Spirits
        Product::create([
            'name' => 'Jameson Whisky (Shot)',
            'category_id' => $spirits->id,
            'buy_price' => 2000,
            'sell_price' => 4000,
            'stock_qty' => 0,
            'unit' => 'shot',
        ]);

        // Soft drinks
        Product::create([
            'name' => 'Coca-Cola 300ml',
            'category_id' => $soft->id,
            'buy_price' => 500,
            'sell_price' => 1000,
            'stock_qty' => 0,
            'unit' => 'bottle',
        ]);

        // Energy drink
        Product::create([
            'name' => 'Red Bull',
            'category_id' => $energy->id,
            'buy_price' => 3000,
            'sell_price' => 4500,
            'stock_qty' => 0,
            'unit' => 'can',
        ]);
    }
}

