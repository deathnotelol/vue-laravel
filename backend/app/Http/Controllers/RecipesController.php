<?php

namespace App\Http\Controllers;

use App\Models\Recipes;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            return Recipes::filter(request(['category']))->orderBy('created_at', 'desc')->paginate(6);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
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
            if (!$recipe) {
                return response()->json([
                    'message' => 'recipe not found',
                    'status' => 404,
                ], 404);
            }
            return $recipe;
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    /**
     * Store and recipe
     * Post /api/recipes
     * @param title, description, category_id, photo(uploaded URL - need to call upload api first)
     */

    public function store()
    {
        try {
            $validator = Validator::make(request()->all(), [
                'title' => 'required',
                'description' => 'required',
                'category_id' => ['required', Rule::exists('categories', 'id')],
                'photo' => 'required',
            ]);
            if ($validator->fails()) {
                $flatteredErrors = collect($validator->errors())->flatMap(function ($e, $field) {
                    return [$field => $e[0]];
                });
                return response()->json([
                    'message' => $flatteredErrors,
                    'status' => 400,
                ], 400);
            }

            //if validation pass
            $recipe = new Recipes;
            $recipe->title = request('title');
            $recipe->description = request('description');
            $recipe->category_id = request('category_id');
            $recipe->photo = request('photo');
            $recipe->save();

            return response()->json($recipe, 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    //update single recipe

    public function update($id)
    {
        try {
            $recipe = Recipes::find($id);
            if (!$recipe) {
                return response()->json([
                    'message' => 'recipe not found',
                    'status' => 404,
                ], 404);
            }

            $validator = Validator::make(request()->all(), [
                'title' => 'required',
                'description' => 'required',
                'category_id' => ['required', Rule::exists('categories', 'id')],
                'photo' => 'required',
            ]);
            if ($validator->fails()) {
                $flatteredErrors = collect($validator->errors())->flatMap(function ($e, $field) {
                    return [$field => $e[0]];
                });
                return response()->json([
                    'message' => $flatteredErrors,
                    'status' => 400,
                ], 400);
            }

            //if validation pass
            $recipe->title = request('title');
            $recipe->description = request('description');
            $recipe->category_id = request('category_id');
            $recipe->photo = request('photo');
            $recipe->save();

            return response()->json($recipe, 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    //upload image api
    //POST /api/recipes/upload
    public function upload()
    {
        try { 
            $validator = Validator::make(request()->all(), [
            'photo' => ['required', 'image'],
        ]);
        if ($validator->fails()) {
            $flatteredErrors = collect($validator->errors())->flatMap(function ($e, $field) {
                return [$field => $e[0]];
            });
            return response()->json([
                'message' => $flatteredErrors,
                'status' => 400,
            ], 400);
        }
        //if validation pass for upload
      $path = '/storage/'. request('photo')->store('/recipes');
      return [
        'path' => $path,
        'status' => 200
      ];

    } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }

    //delete single recipe
    public function destroy($id)
    {
        try {
            $recipe = Recipes::find($id);
            if (!$recipe) {
                return response()->json([
                    'message' => 'recipe not found',
                    'status' => 404,
                ], 404);
            }
            $recipe->delete();
            return $recipe;
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ], 500);
        }
    }
}
