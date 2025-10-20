<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    use ApiResponse;

    //  عرض كل الوصفات
    public function index()
    {
        try {
            $recipes = Recipe::with('category', 'ingredients')->get();
            return $this->successResponse($recipes, 'Recipes retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    // إنشاء وصفة جديدة
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'required|exists:categories,id',
                'ingredients' => 'array',
            ]);

            // رفع الصورة إن وُجدت
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('recipes', 'public');
                $data['image'] = $imagePath;
            }

            $recipe = Recipe::create($data);

            if (isset($data['ingredients'])) {
                $syncData = [];
                foreach ($data['ingredients'] as $ingredient) {
                    $syncData[$ingredient['id']] = ['quantity' => $ingredient['quantity'] ?? null];
                }
                $recipe->ingredients()->sync($syncData);
            }

            DB::commit();
            return $this->successResponse($recipe->load('category', 'ingredients'), 'Recipe created successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

//    public function store(Request $request)
//    {
//        DB::beginTransaction();
//        try {
//            $data = $request->validate([
//                'title' => 'required|string|max:255',
//                'description' => 'nullable|string',
//                'image' => 'nullable|string',
//                'category_id' => 'required|exists:categories,id',
//                'ingredients' => 'array',
//            ]);
//
//            $recipe = Recipe::create($data);
//
//            if (isset($data['ingredients'])) {
//                $syncData = [];
//                foreach ($data['ingredients'] as $ingredient) {
//                    $syncData[$ingredient['id']] = ['quantity' => $ingredient['quantity'] ?? null];
//                }
//                $recipe->ingredients()->sync($syncData);
//            }
//
//            DB::commit();
//            return $this->successResponse($recipe->load('category', 'ingredients'), 'Recipe created successfully', 201);
//        } catch (\Exception $e) {
//            DB::rollBack();
//            return $this->errorResponse($e->getMessage());
//        }
//    }

    //  عرض وصفة واحدة
    public function show($id)
    {
        try {
            $recipe = Recipe::with('category', 'ingredients')->findOrFail($id);
            return $this->successResponse($recipe, 'Recipe retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    //  تحديث وصفة
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $recipe = Recipe::findOrFail($id);

            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
                'ingredients' => 'array',
            ]);

            $recipe->update($data);

            if (isset($data['ingredients'])) {
                $syncData = [];
                foreach ($data['ingredients'] as $ingredient) {
                    $syncData[$ingredient['id']] = ['quantity' => $ingredient['quantity'] ?? null];
                }
                $recipe->ingredients()->sync($syncData);
            }

            DB::commit();
            return $this->successResponse($recipe->load('category', 'ingredients'), 'Recipe updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    // حذف وصفة
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $recipe = Recipe::findOrFail($id);
            $recipe->delete();
            DB::commit();

            return $this->successResponse(null, 'Recipe deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }
}
