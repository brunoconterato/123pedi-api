<?php

namespace Drinking\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Drinking\Repositories\OrderRepository;
use Drinking\Models\Order;
use Drinking\Validators\OrderValidator;

/**
 * Class OrderRepositoryEloquent
 * @package namespace Drinking\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    public function getByOrderIdAndRetailerId($orderId, $retailerId){
        $result = $this->with(['client','items'])->findWhere([
            'id'=> $orderId,
            'retailer_id'=> $retailerId
        ]);

        $result = $result->first();
        if ($result) {
            $result->items->each(function ($item) {
                $item->product;
            });
        }
        return $result;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
