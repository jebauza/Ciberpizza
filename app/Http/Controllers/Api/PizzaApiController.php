<?php

namespace App\Http\Controllers\Api;

use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PizzaResource;
use App\Http\Requests\PizzaStoreUpdateRequest;

class PizzaApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pizzas = Pizza::name($request->name)
                        ->with('ingredients')
                        ->orderBy('name')
                        ->get();

        PizzaResource::withoutWrapping();
        return PizzaResource::collection($pizzas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PizzaStoreUpdateRequest $request)
    {
        try {
            DB::beginTransaction();

            $newPizza = new Pizza($request->all());
            if ($newPizza->save()) {
                $newPizza->ingredients()->attach($request->ingredients);
            }

            DB::commit();
            return response()->json([
                'message'=>'Save successfully',
                'pizza'=> new PizzaResource($newPizza)
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
        if (!$pizza = Pizza::find($id)) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json(new PizzaResource($pizza));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PizzaStoreUpdateRequest $request, $id)
    {
        if (!$pizza = Pizza::find($id)) {
            return response()->json(['message' => 'Not found'], 404);
        }

        try {
            DB::beginTransaction();

            $pizza->fill($request->all());
            if ($pizza->save()) {
                $pizza->ingredients()->sync($request->ingredients);
            }

            DB::commit();
            return response()->json([
                'message'=>'Save successfully',
                'pizza'=> new PizzaResource($pizza)
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
        if (!$pizza = Pizza::find($id)) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $pizza->delete();

        return response()->json([
            'message'=>'Deleted successfully',
            'pizza'=> new PizzaResource($pizza)
        ]);
    }
}
