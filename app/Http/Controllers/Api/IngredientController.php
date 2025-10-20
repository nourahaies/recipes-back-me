<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngredientController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $ingredients = Ingredient::all();
            return $this->successResponse($ingredients, 'Ingredients fetched successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to fetch ingredients', 500, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:ingredients',
            'unit' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $ingredient = Ingredient::create($request->all());
            DB::commit();
            return $this->successResponse($ingredient, 'Ingredient created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to create ingredient', 500, $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $ingredient = Ingredient::findOrFail($id);
            return $this->successResponse($ingredient, 'Ingredient fetched successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Ingredient not found', 404, $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|unique:ingredients,name,' . $id,
            'unit' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $ingredient = Ingredient::findOrFail($id);
            $ingredient->update($request->all());
            DB::commit();
            return $this->successResponse($ingredient, 'Ingredient updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to update ingredient', 500, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $ingredient = Ingredient::findOrFail($id);
            $ingredient->delete();
            DB::commit();
            return $this->successResponse(null, 'Ingredient deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to delete ingredient', 500, $e->getMessage());
        }
    }
}
