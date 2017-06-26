<?php

namespace Drinking\Http\Controllers\API\Search;

use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\CategoryRepository;
use Drinking\Repositories\ProductRepository;
use Drinking\Repositories\StockItemRepository;

class CategoriesSeedController extends Controller
{
    /**
     * @var StockItemRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository){

        $this->categoryRepository = $categoryRepository;
    }
    
    public function index(){
        $categories = $this->categoryRepository->all();

        return $categories;
    }
}
