<?php

namespace App\Models;

use App\User;
use App\Models\Pizza;
use App\Events\OrderCreatedEvent;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['user_id', 'delivery_time', 'price', 'description'];

    protected $dispatchesEvents = [
        'created' => OrderCreatedEvent::class
    ];

    // Relaciones
    public function pizzas()
    {
        return $this->belongsToMany(Pizza::class, 'order_pizza', 'order_id', 'pizza_id')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

