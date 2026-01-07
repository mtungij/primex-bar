<?php
namespace Database\Seeders;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Main categories
        $alcohol = Category::create(['name' => 'Alcohol']);
        $nonAlcohol = Category::create(['name' => 'Non-Alcohol']);

        // Alcohol subcategories
        Category::create(['name' => 'Beer', 'parent_id' => $alcohol->id]);
        Category::create(['name' => 'Wine', 'parent_id' => $alcohol->id]);
        Category::create(['name' => 'Spirits', 'parent_id' => $alcohol->id]);
        Category::create(['name' => 'Whiskey', 'parent_id' => $alcohol->id]);
     

        // Non-alcohol subcategories
        Category::create(['name' => 'Soft Drinks', 'parent_id' => $nonAlcohol->id]);
        Category::create(['name' => 'Energy Drinks', 'parent_id' => $nonAlcohol->id]);
        Category::create(['name' => 'Water', 'parent_id' => $nonAlcohol->id]);
           Category::create(['name' => 'Juice', 'parent_id' => $nonAlcohol->id]);
    }
}
