<?php

namespace Drinking\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class CartItemGetter extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'stock_item_id',
        'quantity',
        'latitude',
        'longitude'
    ];

}
