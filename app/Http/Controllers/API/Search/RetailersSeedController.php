<?php

namespace Drinking\Http\Controllers\API\Search;

use Drinking\Http\Controllers\Controller;
use Drinking\Models\Retailer;
use Drinking\Repositories\RetailerRepository;
use Drinking\Repositories\RetailerRepositoryEloquent;
use Drinking\Repositories\StockItemRepository;

class RetailersSeedController extends Controller
{
    /**
     * @var StockItemRepository
     */
    private $retailerRepository;

    public function __construct(RetailerRepository $retailerRepository){

        $this->retailerRepository = $retailerRepository;
    }

    public function index(){
        $retailers = $this->retailerRepository->with([])->all();

        foreach($retailers as $retailer) {
            $retailer['name'] = $retailer->user->name;
            unset($retailer['user']);
        }

        return $retailers;
    }
}
