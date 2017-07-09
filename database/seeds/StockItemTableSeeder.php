<?php

use Drinking\Models\StockItem;
use Drinking\Repositories\ProductRepository;
use Drinking\Repositories\RetailerRepository;
use Illuminate\Database\Seeder;

class StockItemTableSeeder extends Seeder
{

    private $productRepository;
    /**
     * @var RetailerRepository
     */
    private $retailerRepository;

    public function __construct(ProductRepository $productRepository, RetailerRepository $retailerRepository)
    {
        $this->productRepository = $productRepository;
        $this->retailerRepository = $retailerRepository;
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
        $retailers = $this->retailerRepository->all();


        //Não consegui acessar os products
        foreach ($products as $product) {
            foreach ($retailers as $retailer){
                factory(StockItem::class)->create([
                    'product_id' => $product->id,
                    'retailer_id' => $retailer->id,
                    'quantity' => random_int(88888, 99999),
                    'price' => rand(0.01,100.0)
                ]);
            }
        }
    }
}
