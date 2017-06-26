<?php

namespace Drinking\Http\Controllers\API\Search;

use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\ProductRepository;
use Drinking\Repositories\StockItemRepository;

class ProductsSeedController extends Controller
{
    /**
     * @var StockItemRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository){

        $this->productRepository = $productRepository;
    }
    
    public function index(){
        $products = $this->productRepository->all();

        return $products;
    }
}
