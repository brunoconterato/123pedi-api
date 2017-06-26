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

        $faker = Faker\Factory::create();
        $products = $this->productRepository->all();

        //Não consegui acessar os products
        foreach ($products as $product) {
            $retailers = 3;

            for ($i=1; $i<=$retailers; $i++) {
                factory(StockItem::class)->create([
                    'product_id' => $product->id,
                    'retailer_id' => $i,
                    'quantity' => random_int(88888, 99999),
                    'price' => rand(0.01,100.0)
                ]);
            }
        }

    }
}
