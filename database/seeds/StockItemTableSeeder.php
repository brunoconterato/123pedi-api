<?php

use Drinking\Models\StockItem;
use Drinking\Repositories\ProductRepository;
use Illuminate\Database\Seeder;

class StockItemTableSeeder extends Seeder
{

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $start_date = date('d-m-Y',1488412799);
        $end_date = date('d-m-Y',1514764799);

        $faker = Faker\Factory::create();

        $products = $this->productRepository->all();

//        for ($productId = 1; $productId <= 20 ; $productId++ )
//            if($productId != 6)
//                factory(StockItem::class)->create([
//                    'product_id' => $productId,
//                    'retailer_id' => 1,
//                    'quantity' => random_int(88888, 99999),
//                    'price' => $price,
//                    'min_selling_price' => $min_selling_price,
//                    'cost_price' => $cost_price,
//                    'expiration_date' => $faker->dateTimeBetween($start_date, $end_date),
//                ]);


        //Não consegui acessar os products
        foreach ($products as $product) {
            $retailers = 3;

            for ($i=1; $i<=$retailers; $i++) {
                $price = rand(0.01,100.0);
                $min_selling_price = rand(0.01, $price);
                $cost_price = rand(0.01, $min_selling_price*0.9);

                factory(StockItem::class)->create([
                    'product_id' => $product->id,
                    'retailer_id' => $i,
                    'quantity' => random_int(88888, 99999),
                    'price' => $price,
                    'min_selling_price' => $min_selling_price,
                    'cost_price' => $cost_price,
                    'expiration_date' => $faker->dateTimeBetween($start_date, $end_date),
                ]);
            }
        }

    }
}
