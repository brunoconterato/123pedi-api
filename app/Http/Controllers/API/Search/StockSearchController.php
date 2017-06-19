<?php

namespace Drinking\Http\Controllers\API\Search;

use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\StockItemRepository;

class StockSearchController extends Controller
{
    /**
     * @var StockItemRepository
     */
    private $stockItemRepository;

    public function __construct(StockItemRepository $stockItemRepository){

        $this->stockItemRepository = $stockItemRepository;
    }
    
    public function index(){
//        $stockItems = $this->stockItemRepository->where('retailer_id','=',1);

        $retailerId = 1;
        $stockItems = $this->stockItemRepository->with(['retailer', 'product', 'product.category'])->scopeQuery(function ($query) use ($retailerId) {
            return $query->where('retailer_id','=',$retailerId);
        })->all();
        
        //TODO: retirar replicações

        return $stockItems;
    }
}
