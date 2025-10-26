<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\IngredientController;
use App\Http\Controllers\Api\RecipeController;
use Illuminate\Support\Facades\Route;

// ======================
// AUTH (public routes)
// ======================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ======================
// AUTHENTICATED (أي مستخدم داخل)
// ======================
Route::middleware('auth:sanctum')->group(function () {
    // أي مستخدم يقدر يعمل logout
    Route::post('/logout', [AuthController::class, 'logout']);
});

// ======================
// ADMIN ONLY (خاص بالأدمين فقط)
// ======================
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    // 🔒 CATEGORIES
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/edit/{id}', [CategoryController::class, 'update']);
    Route::delete('/categories/delete/{id}', [CategoryController::class, 'destroy']);

    // 🔒 INGREDIENTS
    Route::post('/ingredients', [IngredientController::class, 'store']);
    Route::put('/ingredients/edit/{id}', [IngredientController::class, 'update']);
    Route::delete('/ingredients/delete/{id}', [IngredientController::class, 'destroy']);

    // 🔒 RECIPES
    Route::post('/recipes', [RecipeController::class, 'store']);
    Route::put('/recipes/edit/{id}', [RecipeController::class, 'update']);
    Route::delete('/recipes/delete/{id}', [RecipeController::class, 'destroy']);
});

// ======================
// PUBLIC (read-only)
// ======================
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/show/{id}', [CategoryController::class, 'show']);

Route::get('/ingredients', [IngredientController::class, 'index']);
Route::get('/ingredients/show/{id}', [IngredientController::class, 'show']);

Route::get('/recipes/index', [RecipeController::class, 'index']);
Route::get('/recipes/show/{id}', [RecipeController::class, 'show']);
