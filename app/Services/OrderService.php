<?php
/**
 * Created by PhpStorm.
 * User: brcon
 * Date: 25/01/2017
 * Time: 02:21
 */

namespace Drinking\Services;


use Drinking\Models\Order;
use Drinking\Repositories\OrderRepositoryEloquent;
use Drinking\Repositories\StockItemRepositoryEloquent;
use Illuminate\Support\Facades\Request;

class OrderService
{
    /**
     * @var OrderRepositoryEloquent
     */
    private $orderRepository;
    /**
     * @var StockItemRepositoryEloquent
     */
    private $stockItemRepository;

    public function __construct(
        OrderRepositoryEloquent $orderRepository,
        StockItemRepositoryEloquent $stockItemRepository)
    {

        $this->orderRepository = $orderRepository;
        $this->stockItemRepository = $stockItemRepository;
    }

    public function create(array $data, Request $request){
        \DB::beginTransaction();

        try{
            $data['status']='Pendente';

            $orderItems = $data['items'];
            unset($data['items']);

            $order = $this->orderRepository->create($data);
            $total = 0;

            //TODO: essa parte é problemática. Parece resolvido, mas necessita teste
            foreach($orderItems as $orderItem) {
                $orderItem['price'] = $this->stockItemRepository->find($orderItem->stockItem_id)->price;
                
                $order->items()->create($orderItem);

                $total += $orderItem['price']*$orderItem['quantity'];
            }

            $order->total = $total;

            $order->save();

            \DB::commit();

            return $order;
        }catch(\Exception $e){
            \DB::rollback();
            throw $e;
        }
    }

    public function updateStatus($orderId, $retailerId, $newStatus)
    {
        \DB::beginTransaction();

        try {
            $order = $this->orderRepository->getByOrderIdAndRetailerId($orderId, $retailerId);

            $availableStatus = ['Pendente','A caminho', 'Entregue', 'Cancelado'];

            if ($order instanceof Order) {
                foreach($availableStatus as $status){
                    if($newStatus == $status) {
                        $order->status = $newStatus;
                        $order->save();
                        return $order;
                    }
                }
            }

            return false;

        }catch (\Exception $e){
            \DB::rollback();
            throw $e;
        }
    }
}