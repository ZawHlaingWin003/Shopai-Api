<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Men\'s Clothing',
            'Women\'s Clothing',
            'Electronics'
        ];
        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => str()->slug($category)
            ]);
        }


        $sub_categories_one = [
            'Shirts',
            'Pants',
            'Shoes',
            'Backpacks',
            'Belts',
            'Accessories',
            'Watches'
        ];
        foreach ($sub_categories_one as $category) {
            SubCategory::create([
                'name' => $category,
                'slug' => str()->slug($category),
                'category_id' => 1
            ]);
        }
        $sub_categories_two = [
            'Skirts',
            'Shirts',
            'Pants',
            'Shoes',
            'Bags',
            'Accessories',
        ];
        foreach ($sub_categories_two as $category) {
            SubCategory::create([
                'name' => $category,
                'slug' => str()->slug($category),
                'category_id' => 2
            ]);
        }
        $sub_categories_three = [
            'Cellphones',
            'Earphones',
            'Computer & Office',
            'Household Appliances',
        ];
        foreach ($sub_categories_three as $category) {
            SubCategory::create([
                'name' => $category,
                'slug' => str()->slug($category),
                'category_id' => 3
            ]);
        }
    }
}
