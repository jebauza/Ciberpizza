<?php

namespace App\Http\Controllers\Api;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\IngredientResource;

class IngredientApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ingredients = Ingredient::name($request->name)
                        ->orderBy('name')
                        ->paginate();

        return IngredientResource::collection($ingredients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IngredientStoreUpdateRequest $request)
    {
        try {
            DB::beginTransaction();

            $newIngredient = new Ingredient($request->all());
            $newIngredient->save();

            DB::commit();
            return response()->json([
                'message'=>'Save successfully',
                'ingredient'=> new IngredientResource($newIngredient)
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$ingredient = Ingredient::find($id)) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new IngredientResource($ingredient));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(IngredientStoreUpdateRequest $request, $id)
    {
        if (!$ingredient = Ingredient::find($id)) {
            return response()->json(['message' => 'Not found'], 404);
        }

        try {
            DB::beginTransaction();

            $ingredient->fill($request->all());
            $ingredient->save();

            DB::commit();
            return response()->json([
                'message'=>'Save successfully',
                'ingredient'=> new IngredientResource($ingredient)
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$ingredient = Ingredient::find($id)) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $ingredient->delete();

        return response()->json([
            'message'=>'Deleted successfully',
            'ingredient'=> new IngredientResource($ingredient)
        ]);
    }
}
