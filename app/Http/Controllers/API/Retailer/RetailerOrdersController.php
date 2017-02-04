<?php

namespace Drinking\Http\Controllers\API\Retailer;

use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\OrderRepository;
use Drinking\Repositories\OrderRepositoryEloquent;
use Drinking\Repositories\UserRepository;
use Drinking\Repositories\UserRepositoryEloquent;
use Drinking\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetailerOrdersController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(OrderRepositoryEloquent $orderRepository,
                                UserRepositoryEloquent $userRepository,
                                OrderService $orderService)
    {

        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->orderService = $orderService;
    }

    public function index(){
        $retailerId = $this->userRepository->find(Auth::user()->id)->retailer->id;

        $orders = $this->orderRepository->with(['items'])->scopeQuery(function($query) use($retailerId){
            return $query->where('retailer_id','=',$retailerId);
        })->paginate();
        
        return $orders;
    }

    public function show($orderId){
        $retailerId = $this->userRepository->find(Auth::user()->id)->retailer->id;
        
        $order = $this->orderRepository->find($orderId);

        if($order->retailer_id == $retailerId)
            return $order;
        else
        {
            return null;
        }
    }
    
    public function updateStatus(Request $request, $orderId){
        $retailerId = $this->userRepository->find(Auth::user()->id)->retailer->id;

        $order = $this->orderRepository->find($orderId);

        if($order->retailer_id == $retailerId)
        {
            $order = $this->orderService->updateStatus($orderId, $retailerId, $request->get('status'));

            return $order;
        }
        else
        {
            return null;
        }
    }
}
