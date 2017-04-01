<?php

namespace Drinking\Http\Controllers\Admin;

use Drinking\Http\Controllers\Controller;
use Drinking\Http\Requests\Admin\AdminRetailerRequest;
use Drinking\Http\Requests\Admin\AdminStockItemRequest;
use Drinking\Repositories\ProductRepository;
use Drinking\Repositories\RetailerRepository;
use Drinking\Repositories\StockItemRepository;
use Illuminate\Http\Request;

class RetailersController extends Controller
{

    private $retailerRepository;
    private $stockItemRepository;
    private $productRepository;

    public function __construct(RetailerRepository $retailerRepository,
                                StockItemRepository $stockItemRepository,
                                ProductRepository $productRepository)
    {
        $this->retailerRepository = $retailerRepository;
        $this->stockItemRepository = $stockItemRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $retailers = $this->retailerRepository->paginate('15', array('*'));

        return view('admin.retailers.index', compact('retailers'));
    }

    public function create()
    {
        return view('admin.retailers.create');
    }

    public function store(AdminRetailerRequest $request)
    {
        $data = $request->all();
        $this->retailerRepository->create($data);

        return redirect()->route('admin.retailers.index');
    }

    public function edit($id)
    {
        $retailer = $this->retailerRepository->find($id);

        return view('admin.retailers.edit', compact('retailer'));
    }

    public function update(AdminRetailerRequest $request, $id)
    {
        $data = $request->all();
        $this->retailerRepository->update($data, $id);

        return redirect()->route('admin.retailers.index');
    }

    public function stock($retailerId)
    {
        $stockItems = $this->stockItemRepository->scopeQuery(function($query) use($retailerId){
            return $query->where('retailer_id','=',$retailerId);
        })->paginate();

        return view('admin.retailers.stock.index', compact('retailerId','stockItems'));
    }

    public function createStockItem($retailerId)
    {
        $products = $this->productRepository->pluck();
        return view('admin.retailers.stock.create', compact('products', 'retailerId') );
    }

    public function storeStockItem(AdminStockItemRequest $request, $retailerId)
    {
        $data = $request->all();

        $data['retailer_id'] = $retailerId;
        $this->stockItemRepository->create($data);

        return redirect()->route('admin.retailers.stock.index', ['id'=>$retailerId]);
    }

    public function editStockItem($stockItemId)
    {
        $stockItem = $this->stockItemRepository->find($stockItemId);
        $products = $this->productRepository->pluck();

        return view('admin.retailers.stock.edit', compact('stockItem', 'products'));
    }

    public function updateStockItem(Request $request, $stockItemId)
    {
        $data = $request->all();
        $this->stockItemRepository->update($data, $stockItemId);

        $stockItem = $this->stockItemRepository->find($stockItemId);

        return redirect()->route('admin.retailers.stock.index',['id' => $stockItem->retailer_id]);
    }

    public function destroyStockItem($stockItemId){
        $stockItem = $this->stockItemRepository->find($stockItemId);

        $this->stockItemRepository->delete($stockItemId);

        return redirect()->route('admin.retailers.stock.index',['id' => $stockItem->retailer_id]);
    }
}