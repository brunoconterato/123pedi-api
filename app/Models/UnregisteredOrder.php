<?php

namespace Drinking\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class UnregisteredOrder extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'street_address',
        'address_line_2',
        'neighborhood',
        'city',
        'state',
        'zipcode',
        'lat_coordinate',
        'long_coordinate',

        'retailer_id',
        'total',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(UnregisteredOrderItem::class);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class, 'retailer_id', 'id');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
