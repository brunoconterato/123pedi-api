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
        'unregistered_order_id'
    ];

    public function stockItem()
    {
        return $this->belongsTo(StockItem::class);
    }

    //TODO: Corrigir: cada orderItem eh um produco
    public function product(){
        return $this->hasMany(Product::class);
    }
}
