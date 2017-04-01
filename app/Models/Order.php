<?php

namespace Drinking\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Order extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'client_id',
        'retailer_id',
        'total',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class, 'retailer_id');
//        return $this->belongsTo(Retailer::class, 'retailer_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
