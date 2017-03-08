<?php
/**
 * Created by PhpStorm.
 * User: brcon
 * Date: 25/01/2017
 * Time: 02:21
 */

namespace Drinking\Services;

use Drinking\Models\UnregisteredOrder;
use Drinking\Repositories\StockItemRepositoryEloquent;

use Drinking\Repositories\UnregisteredOrderItemRepositoryEloquent;
use Drinking\Repositories\UnregisteredOrderRepositoryEloquent;
use Illuminate\Http\Request;

//TODO: fazer toda a implementação desta classe
class UnregisteredOrderService
{
    /**
     * @var UnregisteredOrderRepositoryEloquent
     */
    private $orderRepository;
    /**
     * @var StockItemRepositoryEloquent
     */
    private $stockItemRepository;
    /**
     * @var UnregisteredOrderItemRepositoryEloquent
     */
    private $orderItemRepository;

    public function __construct(
        UnregisteredOrderRepositoryEloquent $orderRepository,
        UnregisteredOrderItemRepositoryEloquent $orderItemRepository,
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
            $dataOrder = $data;

            $itensQuantity = sizeof($data['stockitems_id']);

            $total = 0;

            //criando orderItems
            for ($i = 0; $i < $itensQuantity; $i++)
            {
                $orderItemsData[$i]['stockItem_id'] = $data['stockitems_id'][$i];
                $orderItemsData[$i]['quantity'] = $data['stockitems_quantity'][$i];

                $stockItemId = $orderItemsData[$i]['stockItem_id'];
                $stockItems[$i] = $this->stockItemRepository->find($stockItemId);
                $orderItemsData[$i]['price'] = $stockItems[$i]->price;

                //updating total
                $total += $orderItemsData[$i]['price']*$orderItemsData[$i]['quantity'];

                //Decrementing stockItem envolvido na transaction
                $stockItems[$i]->quantity = $stockItems[$i]->quantity - $orderItemsData[$i]['quantity'];
                $this->stockItemRepository->update($stockItems[$i]->toArray(), $stockItems[$i]->id);
            }

            //data to create order
            $dataOrder['status'] = 'Pendente';
            $dataOrder['total'] = $total;
            $dataOrder['retailer_id'] = $data['retailer_id'];

            $order = $this->orderRepository->create($dataOrder);

            $order->save();

            //Inserindo orderItems criados na database
            for ($i = 0; $i < $itensQuantity; $i++) {
                $orderItemsData[$i]['unregistered_order_id'] = $order->id;
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

                if ($order instanceof UnregisteredOrder) {
                    if(in_array($newStatus, $availableStatusLowerCase)){
                        $order->status = $newStatus;
                        $order->save();
                        return $order;
                    }
                    else{
                        return null;
                    }
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