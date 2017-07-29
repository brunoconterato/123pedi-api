<?php

namespace Drinking\Http\Controllers\API\Search;

use Carbon\Carbon;
use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\CategoryRepository;
use Drinking\Repositories\OpenIntervalRepository;
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
    /**
     * @var OpenIntervalRepository
     */
    private $openIntervalRepository;

    public function __construct(
        RetailerRepository $retailerRepository,
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        StockItemRepository $stockItemRepository,
        OpenIntervalRepository $openIntervalRepository)
    {
        $this->retailerRepository = $retailerRepository;
        $this->productRepository = $productRepository;
        $this->stockItemRepository = $stockItemRepository;
        $this->categoryRepository = $categoryRepository;
        $this->openIntervalRepository = $openIntervalRepository;
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


        /**
         * Getting Opened Retailers
         */
        
        $now = Carbon::now(-3);
//        dd($now);

        $nearOpenedRetailers = [];

        foreach ($nearRetailers as $retailer){

            $day_interval = $this->openIntervalRepository->scopeQuery(function($query) use($retailer, $now) {
                return $query->where('retailer_id','=',$retailer->id)->where('day_of_week','=',$now->dayOfWeek);
            })->first();

            $open_time = $day_interval['open_time'];
            $open_time_carbon = new Carbon($open_time,-3);

            $close_time = $day_interval['close_time'];
            $close_time_carbon = new Carbon($close_time,-3);

            if($now->between($open_time_carbon,$close_time_carbon))
                $nearOpenedRetailers[] = $retailer;
        }

        /*
         * Getting StockItems
         */
        $stockItems = [];
        foreach($nearOpenedRetailers as $retailer) {
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

        return array('retailers' => $nearOpenedRetailers, 'products' => $products, 'categories' => $categories, 'items' => $stockItems);
    }
}
