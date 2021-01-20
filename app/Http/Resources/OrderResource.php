<?php

namespace App\Http\Resources;

use App\Http\Resources\PizzaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => $this->user,
            'delivery_time' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'ingredients' => PizzaResource::collection($this->pizzas),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
