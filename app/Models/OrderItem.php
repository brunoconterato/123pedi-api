<?php

namespace Drinking\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class OrderItem extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'stockItem_id',
        'order_id',
        //TODO: retirar o price, que virá do stockItem
        'price',
        'quantity'
    ];

    public function stockItem()
    {
        return $this->belongsTo(StockItem::class);
    }

    //TODO: Corrigir: cada order item eh um produto
    public function product(){
        return $this->hasMany(Product::class);
    }
}
