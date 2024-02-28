<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RecipesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//get all categories
Route::get('/categories', [CategoryController::class,'index']);

//get all recipes
Route::get('/recipes', [RecipesController::class,'index']);

//get single recipes
Route::get('/recipes/{recipe}', [RecipesController::class, 'show']);

//delete single recipes
Route::delete('/recipes/{recipe}', [RecipesController::class, 'destroy']);
