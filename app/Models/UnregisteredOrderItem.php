<?php

namespace Drinking\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class UnregisteredOrderItem extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'quantity',
        'unregistered_order_id',
        'stock_item_id'
    ];

    public function stockItem()
    {
        return $this->belongsTo(StockItem::class);
//        return $this->hasOne(StockItem::class);
    }

    public function order(){
        return $this->belongsTo(UnregisteredOrder::class);
    }
}
