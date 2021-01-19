<?php

namespace App\Http\Resources;

use App\Http\Resources\IngredientResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PizzaResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'ingredients' => IngredientResource::collection($this->ingredients),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
