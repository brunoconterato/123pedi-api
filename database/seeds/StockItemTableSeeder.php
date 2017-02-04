<?php

use Drinking\Models\StockItem;
use Illuminate\Database\Seeder;

class StockItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(StockItem::class, 100)->create();
    }
}
