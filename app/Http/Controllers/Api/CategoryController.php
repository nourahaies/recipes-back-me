<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $categories = Category::all();
            return $this->successResponse($categories, 'Categories fetched successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to fetch categories', 500, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $category = Category::create($request->all());
            DB::commit();
            return $this->successResponse($category, 'Category created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to create category', 500, $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return $this->successResponse($category, 'Category fetched successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Category not found', 404, $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|unique:categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $category = Category::findOrFail($id);
            $category->update($request->all());
            DB::commit();
            return $this->successResponse($category, 'Category updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to update category', 500, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            DB::commit();
            return $this->successResponse(null, 'Category deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to delete category', 500, $e->getMessage());
        }
    }
}
