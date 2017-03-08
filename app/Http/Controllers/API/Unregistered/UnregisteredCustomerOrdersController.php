<?php

namespace Drinking\Http\Controllers\API\Unregistered;

use Carbon\Carbon;
use Drinking\Http\Controllers\Controller;
use Drinking\Repositories\StockItemRepository;
use Drinking\Repositories\UnregisteredOrderRepository;
use Drinking\Services\UnregisteredOrderService;
use Illuminate\Http\Request;

class UnregisteredCustomerOrdersController extends Controller
{
    /**
     * @var UnregisteredOrderRepository
     */
    private $orderRepository;
    /**
     * @var UnregisteredOrderService
     */
    private $orderService;
    /**
     * @var StockItemRepository
     */
    private $stockItemRepository;

    public function __construct(UnregisteredOrderRepository $orderRepository,
                                StockItemRepository $stockItemRepository,
                                UnregisteredOrderService $orderService)
    {

        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
        $this->stockItemRepository = $stockItemRepository;
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

    public function cancelOrder($orderId){

        $order = $this->orderRepository->find($orderId);

        $deadLineCarbon = Carbon::parse($this->getDeadLineToCancelOrderDT($orderId));

        //Verifica se ainda é possível o cliente cancelar a ordem
        if(Carbon::now()->lessThanOrEqualTo($deadLineCarbon))
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
