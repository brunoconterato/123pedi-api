<?php

namespace Drinking\Http\Controllers\Retailer;

use Drinking\Http\Controllers\Controller;
use Drinking\Http\Requests\RetailerStockItemRequest;
use Drinking\Repositories\ProductRepository;
use Drinking\Repositories\StockItemRepository;
use Drinking\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var StockItemRepository
     */
    private $stockItemRepository;

    public function __construct(ProductRepository $productRepository,
                                UserRepository $userRepository,
                                StockItemRepository $stockItemRepository){

        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
        $this->stockItemRepository = $stockItemRepository;
    }

    public function index(){
        $retailerId = $this->userRepository->find(Auth::user()->id)->retailer->id;

        $stockItems = $this->stockItemRepository->scopeQuery(function($query) use($retailerId){
            return $query->where('retailer_id','=',$retailerId);
        })->paginate();

        return view('retailer.stock.index', compact('stockItems'));
    }

    public function create(){
        $products = $this->productRepository->pluck();
        return view('retailer.stock.create', compact('products') );
    }

    public function store(RetailerStockItemRequest $request){
        $data = $request->all();
        $retailerId = $this->userRepository->find(Auth::user()->id)->retailer->id;
        $data['retailer_id'] = $retailerId;
        $this->stockItemRepository->create($data);
        return redirect()->route('retailer.stock.index');
    }

    public function edit($id){
        $stockItem = $this->stockItemRepository->find($id);
        $products = $this->productRepository->pluck();

        return view('retailer.stock.edit', compact('stockItem', 'products'));
    }

    public function update(RetailerStockItemRequest $request, $id)
    {
        $data = $request->all();
        $this->stockItemRepository->update($data, $id);

        return redirect()->route('retailer.stock.index');
    }

    public function destroy($id){
        $this->stockItemRepository->delete($id);

        return redirect()->route('retailer.stock.index');
    }
}
