<?php

namespace Modules\OrderModule\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();



        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('order_statuses')->truncate();
        DB::table('order_statuses')->insert(['status' => 'Waiting for Confirmation']);
        DB::table('order_statuses')->insert(['status' => 'Under Preparing']);
        DB::table('order_statuses')->insert(['status' => 'Rejected']);
        DB::table('order_statuses')->insert(['status' => 'Shipping']);
        DB::table('order_statuses')->insert(['status' => 'Delivered']);
        DB::table('order_statuses')->insert(['status' => 'Cancelled']);
        
    }
}
