<?php

namespace Drinking\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class OrderItem extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'stock_item_id',
        'order_id',
        'quantity'
    ];

    public function stockItem()
    {
        return $this->belongsTo(StockItem::class);
    }
}
