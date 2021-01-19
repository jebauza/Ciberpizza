<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PizzaStoreUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $pizza_id = $this->route('id') ?? null;
        return [
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'string',
            'ingredients' => 'bail|required|array|min:1',
            'ingredients.*' => 'integer|exists:ingredients,id'
        ];
    }
}
