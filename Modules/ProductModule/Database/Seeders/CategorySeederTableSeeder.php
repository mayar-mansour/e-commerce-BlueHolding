<?php

namespace Modules\ProductModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\ProductModule\Entities\Category;

class CategorySeederTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic gadgets and devices'],
            ['name' => 'Books', 'description' => 'Various genres of books'],
            ['name' => 'Clothing', 'description' => 'Apparel for men and women'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
