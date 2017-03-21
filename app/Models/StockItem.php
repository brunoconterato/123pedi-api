<?php

namespace Drinking\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class StockItem extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'product_id',
        'retailer_id',
        'quantity',
        'price',
        'min_selling_price',
        'cost_price',
        'expiration_date'
    ];

    public function product(){
        return $this->hasOne(Product::class, 'id', 'product_id');
//        return $this->belongsTo(Product::class);
    }

    //usada inicialmente para listar estoque de cada farmacia (em testes)
    public function retailer(){
        return $this->belongsTo(Retailer::class);
    }
}
