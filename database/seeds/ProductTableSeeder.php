<?php

use Drinking\Models\Product;
use Drinking\Models\StockItem;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Product::class, 200)->create()->each(function ($p) {
            //criando 1 stockItem para cada product
            $p->stockItems()->save(factory(StockItem::class)->make());
        });
    }
}
