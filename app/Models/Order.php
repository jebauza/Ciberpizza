<?php

namespace App\Models;

use App\Events\OrderCreatedEvent;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['user_id', 'delivery_time', 'price', 'description'];

    protected $dispatchesEvents = [
        'created' => OrderCreatedEvent::class
    ];

}

