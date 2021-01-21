<?php

namespace App\Models;

use App\User;
use App\Models\Pizza;
use DateTimeInterface;
use App\Events\OrderCreatedEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['user_id', 'delivery_time', 'price', 'description'];

    protected $dispatchesEvents = [
        'created' => OrderCreatedEvent::class
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

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

    /* Scopes */
    public function scopeClient($query, $user = null)
    {
        if($user){
            return $query->whereHas('user', function (Builder $query) use($user){
                $query->nameEmail($user);
            });
        }
    }

    public function scopePizza($query, $pizza = null)
    {
        if($pizza){
            return $query->whereHas('pizzas', function (Builder $query) use($pizza){
                $query->name($pizza);
            });
        }
    }
}

