<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pizza;

class Ingredient extends Model
{
    protected $table = 'ingredients';

    protected $fillable = ['name', 'price', 'description'];

    // Relaciones
    public function pizzas()
    {
        return $this->belongsToMany(Pizza::class, 'pizza_ingredient', 'ingredient_id', 'pizza_id')
                    ->withTimestamps();
    }

    // Scopes
    public function scopeName($query, $name)
    {
        if($name){
            return $query->where('name', 'like', "%$name%");
        }
    }
}
