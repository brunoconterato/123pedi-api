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
        $price = rand(0.01,100.0);
        $min_selling_price = rand(0.01, $price);
        $cost_price = rand(0.01, $min_selling_price*0.9);
        $start_date = date('d-m-Y',1488412799);
        $end_date = date('d-m-Y',1514764799);

        $faker = Faker\Factory::create();

        for ($productId = 1; $productId <= 20 ; $productId++ )
            if($productId != 6)
                factory(StockItem::class)->create([
                    'product_id' => $productId,
                    'retailer_id' => 1,
                    'quantity' => random_int(88888, 99999),
                    'price' => $price,
                    'min_selling_price' => $min_selling_price,
                    'cost_price' => $cost_price,
                    'expiration_date' => $faker->dateTimeBetween($start_date, $end_date),
                ]);
    }
}
