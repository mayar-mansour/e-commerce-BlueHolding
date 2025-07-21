<?php

namespace Modules\ProductModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\ProductModule\Entities\Tag;

class TagSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            ['name' => 'New Arrival'],
            ['name' => 'Best Seller'],
            ['name' => 'Discount'],
         
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
