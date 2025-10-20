<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\IngredientController;
use App\Http\Controllers\Api\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//CATEGORIES
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::put('/categories/edit/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/delete/{id}', [CategoryController::class, 'destroy']);
Route::get('/categories/show/{id}', [CategoryController::class, 'show']);


//INGREDIENTS
Route::post('/ingredients', [IngredientController::class, 'store']);
Route::get('/ingredients', [IngredientController::class, 'index']);
Route::put('/ingredients/edit/{id}', [IngredientController::class, 'update']);
Route::delete('/ingredients/delete/{id}', [IngredientController::class, 'destroy']);
Route::get('/ingredients/show/{id}', [IngredientController::class, 'show']);


//RECIPES
Route::post('/recipes', [RecipeController::class, 'store']);
Route::get('/recipes/index', [RecipeController::class, 'index']);
Route::put('/recipes/edit/{id}', [RecipeController::class, 'update']);
Route::delete('/recipes/delete/{id}', [RecipeController::class, 'destroy']);
Route::get('/recipes/show/{id}', [RecipeController::class, 'show']);



//
//use App\Http\Controllers\Api\CategoryController;
//use Illuminate\Support\Facades\Route;
//
//Route::post('/categories',[CategoryController::class,'store']);
