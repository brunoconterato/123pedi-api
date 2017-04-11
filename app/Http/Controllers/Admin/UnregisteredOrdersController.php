<?php

namespace Drinking\Http\Controllers\Admin;

use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\ClientRepository;
use Drinking\Repositories\ProductRepository;
use Drinking\Repositories\RetailerRepository;
use Drinking\Repositories\StockItemRepository;
use Drinking\Repositories\UnregisteredOrderRepository;
use Drinking\Repositories\UserRepository;
use Drinking\Services\UnregisteredOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UnregisteredOrdersController extends Controller
{
    /**
     * @var UnregisteredOrderRepository
     */
    private $orderRepository;
    /**
     * @var ClientRepository
     */
    private $retailerRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var UnregisteredOrderService
     */
    private $orderService;
    /**
     * @var ClientRepository
     */
    private $clientRepository;
    /**
     * @var StockItemRepository
     */
    private $stockItemRepository;

    public function __construct(UnregisteredOrderRepository $orderRepository,
                                ProductRepository $productRepository,
                                ClientRepository $clientRepository,
                                UnregisteredOrderService $orderService,
                                StockItemRepository $stockItemRepository,
                                RetailerRepository $retailerRepository)
    {

        $this->orderRepository = $orderRepository;
        $this->retailerRepository = $retailerRepository;
        $this->productRepository = $productRepository;
        $this->orderService = $orderService;
        $this->clientRepository = $clientRepository;
        $this->stockItemRepository = $stockItemRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->paginate();
        return view('admin.unregisteredorders.index', compact('orders'));
    }

    public function edit($id)
    {
        $list_status_keys = ['Pendente', 'A caminho', 'Entregue', 'Cancelado'];
        //criando list_status com keys e values iguals: necessario pois o html imprime so as keys
        $list_status = array_combine($list_status_keys, $list_status_keys);
        $order = $this->orderRepository->find($id);

        #TODO: fazer listar nomes do User associado ao Pharmacy, no momento está listando cnpj
        $column = 0;
        $retailers = $this->retailerRepository->pluck($column);

        return view('admin.unregisteredorders.edit', compact('order', 'list_status', 'retailers'));
    }

    public function update(Request $request, $id)
    {
        $all = $request->all();

        $this->orderRepository->update($all, $id);

        return redirect()->route('admin.unregisteredorders.index');
    }
    
    #TODO: delete order
    public function destroy()
    {
        
    }
}
