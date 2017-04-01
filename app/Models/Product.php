<?php

namespace Drinking\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Product extends Model implements Transformable
{
    use TransformableTrait;

    //TODO: fillable pharmacy_id
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'manufacturer',
        'brand',
        'image_url'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function stockItems()
    {
        return $this->hasMany(StockItem::class);
    }

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }
}
