<?php

namespace App\Models;

use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    protected $table = 'pizzas';

    protected $fillable = ['name', 'price', 'description'];

    // Relaciones
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'pizza_ingredient', 'pizza_id', 'ingredient_id')
                    ->withTimestamps();
    }
}
