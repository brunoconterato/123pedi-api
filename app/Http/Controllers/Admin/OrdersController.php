<?php

namespace Drinking\Http\Controllers\Admin;

use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\ClientRepository;
use Drinking\Repositories\OrderRepository;
use Drinking\Repositories\ProductRepository;
use Drinking\Repositories\RetailerRepository;
use Drinking\Repositories\StockItemRepository;
use Drinking\Repositories\UserRepository;
use Drinking\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrdersController extends Controller
{
    /**
     * @var OrderRepository
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
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var OrderService
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

    public function __construct(OrderRepository $orderRepository,
                                ProductRepository $productRepository,
                                UserRepository $userRepository,
                                ClientRepository $clientRepository,
                                OrderService $orderService,
                                StockItemRepository $stockItemRepository,
                                RetailerRepository $retailerRepository)
    {

        $this->orderRepository = $orderRepository;
        $this->retailerRepository = $retailerRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
        $this->orderService = $orderService;
        $this->clientRepository = $clientRepository;
        $this->stockItemRepository = $stockItemRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->paginate();
        return view('admin.orders.index', compact('orders'));
    }

    public function edit($id)
    {
        $list_status_keys = ['Pendente', 'A caminho', 'Entregue', 'Cancelado'];
        //criando list_status com keys e values iguals: necessario pois o html imprime so as keys
        $list_status = array_combine($list_status_keys, $list_status_keys);
        $order = $this->orderRepository->find($id);

        #TODO: fazer listar nomes do User associado ao Pharmacy, no momento está listando cnpj
        $retailers = $this->retailerRepository->pluck();

        return view('admin.orders.edit', compact('order', 'list_status', 'retailers'));
    }

    public function update(Request $request, $id)
    {
        $all = $request->all();

        $this->orderRepository->update($all, $id);

        return redirect()->route('admin.orders.index');
    }
    
    #TODO: delete order
    public function destroy()
    {
        
    }
}
