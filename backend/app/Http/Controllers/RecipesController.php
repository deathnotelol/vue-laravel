<?php

namespace App\Http\Controllers;

use App\Models\Recipes;
use Exception;
use Illuminate\Http\Request;

class RecipesController extends Controller
{

    /**
     * get all recipes and filter by category
     * GET - /api/recipes
     * @param category
     * 
     */
    public function index()
    {
        try {
            return Recipes::filter(request(['category']))->paginate(6);
        } catch (Exception $e) {
        return response()->json([
            'message'=> $e->getMessage(),
            'status' => 500,
        ], 500);
        }
    }

    //get single recipe
    //get /api/recipe/id
    public function show($id) 
    {
        try {
            $recipe = Recipes::find($id);
            if(!$recipe) {
                return response()->json([
                    'message'=> 'recipe not found',
                    'status'=> 404,
                ], 404);
            }
            return $recipe;
        } catch (Exception $e) {
        return response()->json([
            'message'=> $e->getMessage(),
            'status' => 500,
        ], 500);
        }
    }

    //delete single recipe
    public function destroy($id)
    {
        try {
            $recipe = Recipes::find($id);
            if(!$recipe) {
                return response()->json([
                    'message'=> 'recipe not found',
                    'status'=> 404,
                ], 404);
            }
            $recipe->delete();
            return $recipe;
        } catch (Exception $e) {
        return response()->json([
            'message'=> $e->getMessage(),
            'status' => 500,
        ], 500);
        }
    }
}
