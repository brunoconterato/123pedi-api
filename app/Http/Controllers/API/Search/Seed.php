<?php

namespace Drinking\Http\Controllers\API\Search;

use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\CategoryRepository;
use Drinking\Repositories\ProductRepository;
use Drinking\Repositories\RetailerRepository;
use Drinking\Repositories\StockItemRepository;
use Illuminate\Http\Request;

class Seed extends Controller
{
    /**
     * @var StockItemRepository
     */
    private $retailerRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var StockItemRepository
     */
    private $stockItemRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(
        RetailerRepository $retailerRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        StockItemRepository $stockItemRepository)
    {
        $this->retailerRepository = $retailerRepository;
        $this->productRepository = $productRepository;
        $this->stockItemRepository = $stockItemRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request){
        /*
         * Getting Retailers Near
         */
        $data = $request->all();
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];

        $allRetailers = $this->retailerRepository->all();

        $nearRetailers = [];
        foreach($allRetailers as $retailer) {
            if($retailer->distanceFrom($latitude, $longitude) <= $retailer['delivery_radius']){
                $retailer['name'] = $retailer->user->name;
                unset($retailer['user']);

                //TODO: fazer os retailers n達o retornarem os items
                //Esta linha n達o funciona:
                unset($retailer->items);

                $nearRetailers[] = $retailer;
            }
        }

        /*
         * Getting StockItems
         */
        $stockItems = [];
        foreach($nearRetailers as $retailer) {
//            echo($retailer);
            foreach ($retailer->items as $stockItem)
                $stockItems[] = $stockItem;
        }
        $stockItems = array_unique($stockItems);

        /*
         * Getting Products
         */
        $products = [];
        foreach($stockItems as $stockItem){
            $products[] = $stockItem->product;
        }
        $products = array_unique($products);

        /*
         * Getting Categories
         */
        $categories = $this->categoryRepository->all();

        return array('retailers' => $nearRetailers, 'products' => $products, 'categories' => $categories, 'items' => $stockItems);
    }
}
