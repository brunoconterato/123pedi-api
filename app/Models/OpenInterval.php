<?php

namespace Drinking\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class OpenInterval extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'retailer_id',
        'day_of_week',
        'start_time',
        "end_time"
    ];

}
