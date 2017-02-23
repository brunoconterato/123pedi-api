<?php

namespace Drinking\Http\Controllers\API\Customer;

use Carbon\Carbon;
use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\OrderRepository;
use Drinking\Repositories\StockItemRepository;
use Drinking\Repositories\UserRepository;
use Drinking\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrdersController extends Controller
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
    /**
     * @var StockItemRepository
     */
    private $stockItemRepository;

    public function __construct(OrderRepository $orderRepository,
                                UserRepository $userRepository,
                                StockItemRepository $stockItemRepository,
                                OrderService $orderService)
    {

        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->orderService = $orderService;
        $this->stockItemRepository = $stockItemRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Funciona
    public function index()
    {
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;

//        $orders = $this->orderRepository->with(['items'])->scopeQuery(function($query) use($clientId){
//            return $query->where('client_id','=',$clientId);
//        })->paginate();


        //seria assim mais rápido?
        $orders = $this->userRepository->find(Auth::user()->id)->client->orders;

        return $orders;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * Funciona fuderosamente bem!
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;

        $data['client_id'] = $clientId;

        if(sizeof($data['stockitems_id']) == sizeof($data['stockitems_quantity'])){
            $numberOfItens = sizeof($data['stockitems_id']);

            //testando se há mais itens em estoque ou igual à quantidade solicitada
            for ($i = 0; $i < $numberOfItens; $i++){
                $stockItemId = $data['stockitems_id'][$i];
                
                $stockItem = $this->stockItemRepository->find($stockItemId);

                if($data['stockitems_quantity'][$i] > $stockItem->quantity){
                    return null;
                }
            }

            $o = $this->orderService->create($data, $request);
            $o = $this->orderRepository->with('items')->find($o->id);

            return $o;
        }

        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
        $order = $this->orderRepository->find($id);

        if((int)$order->client_id == $clientId){
            return $order;
        }

        else
            return null;
    }

    public function cancelOrder($orderId){
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;

        $order = $this->orderRepository->find($orderId);

        $deadLineCarbon = Carbon::parse($this->getDeadLineToCancelOrderDT($orderId));

        //Verifica se é realmente aquele cliente que está tentando cancelar a ordem
        //Verifica se ainda é possível o cliente cancelar a ordem
        if($order->client_id == $clientId and
            Carbon::now()->lessThanOrEqualTo($deadLineCarbon))
        {
            $order = $this->orderService->updateStatus($orderId, 'Cancelada');

            return $order;
        }
        else
        {
            return null;
        }
    }

    //Funcionando, PORRA!!
    public function getDeadLineToCancelOrderDT($orderId){
        $order = $this->orderRepository->find($orderId);

        $orderDT = Carbon::parse($order->created_at);

        $incrementTimeStr = config('constants.minutes_for_user_cancel_order');

        $deadLineDT = $orderDT->addMinutes($incrementTimeStr);

        return $deadLineDT;
    }

    //TODO: passar para private após testes
    public function getRemainingTimeToCancelOrderDT($orderId)
    {
        $deadLineCarbon = Carbon::parse($this->getDeadLineToCancelOrderDT($orderId));

        if(Carbon::now()->greaterThan($deadLineCarbon))
        {
            return null;
        }
        else{
            //retorna um objeto DateInterval
            return $deadLineCarbon->diff(Carbon::now())->format('%I:%S');
        }
    }
}
