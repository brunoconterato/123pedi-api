<?php
/**
 * Created by PhpStorm.
 * User: brcon
 * Date: 25/01/2017
 * Time: 02:21
 */

namespace Drinking\Services;


use Drinking\Models\Order;
use Drinking\Repositories\OrderItemRepositoryEloquent;
use Drinking\Repositories\OrderRepositoryEloquent;
use Drinking\Repositories\StockItemRepositoryEloquent;

use Illuminate\Http\Request;

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
    /**
     * @var OrderItemRepositoryEloquent
     */
    private $orderItemRepository;

    public function __construct(
        OrderRepositoryEloquent $orderRepository,
        OrderItemRepositoryEloquent $orderItemRepository,
        StockItemRepositoryEloquent $stockItemRepository)
    {

        $this->orderRepository = $orderRepository;
        $this->stockItemRepository = $stockItemRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    //Pressupões que todas quantidades de stockItems maior que a quantidade solicitada na ordem!!
    //Isso ocorre pq o estabelecimento não pode querer vender mais do que possui em estoque
    public function create(array $data, Request $request){
        \DB::beginTransaction();

        try{
            $itensQuantity = sizeof($data['stockitems_id']);

            $total = 0;

            //criando orderItems
            for ($i = 0; $i < $itensQuantity; $i++)
            {
                $orderItemsData[$i]['stock_item_id'] = $data['stockitems_id'][$i];
                $orderItemsData[$i]['quantity'] = $data['stockitems_quantity'][$i];

                $stockItemId = $orderItemsData[$i]['stock_item_id'];
                $stockItems[$i] = $this->stockItemRepository->find($stockItemId);
//                $orderItemsData[$i]['price'] = $stockItems[$i]->price;

                //updating total
//                $total += $orderItemsData[$i]['price']*$orderItemsData[$i]['quantity'];
                $total += $stockItems[$i]->price*$orderItemsData[$i]['quantity'];

                //Decrementing stockItem envolvido na transaction
                $stockItems[$i]->quantity = $stockItems[$i]->quantity - $orderItemsData[$i]['quantity'];
                $this->stockItemRepository->update($stockItems[$i]->toArray(), $stockItems[$i]->id);
            }

            //data to create order
            $dataOrder['status'] = 'Pendente';
            $dataOrder['total'] = $total;
            $dataOrder['retailer_id'] = $data['retailer_id'];
            $dataOrder['client_id'] = $data['client_id'];

            $order = $this->orderRepository->create($dataOrder);

            $order->save();


            //Inserindo orderItems criados na database
            for ($i = 0; $i < $itensQuantity; $i++) {
                $orderItemsData[$i]['order_id'] = $order->id;
                $this->orderItemRepository->create($orderItemsData[$i]);
            }

            \DB::commit();

            return $order;
        }catch(\Exception $e){
            \DB::rollback();
            throw $e;
        }
    }


    //TODO: implementar: o update status não deve permitir modificar ordens canceladas


    public function updateStatus($orderId, $newStatus)
    {
        \DB::beginTransaction();
        
        try {
            $order = $this->orderRepository->find($orderId);

            if(strtolower($order->status) != 'cancelada') {
                $availableStatusLowerCase = ['Pendente', 'A caminho', 'Entregue', 'Cancelada'];

                if ($order instanceof Order) {
                    if(in_array($newStatus, $availableStatusLowerCase)){
                        $order->status = $newStatus;
                        $order->save();
                        return $order;
                    }
                    else{
                        return null;
                    }

//                        Deleção?
//                    foreach ($availableStatusLowerCase as $status) {
//                        if ($newStatus == $status) {
//                            $order->status = $newStatus;
//                            $order->save();
//                            return $order;
//                        }
//                    }


                }
                else{
                    return null;
                }
            }
            else {
                return null;
            }

            \DB::commit();
        }catch (\Exception $e){
            \DB::rollback();
            throw $e;
        }
    }
}