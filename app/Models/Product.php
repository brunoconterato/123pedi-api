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
        'brand'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
