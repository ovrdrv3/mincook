<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;

class RecipeController extends Controller
{
    protected $fillable = [];

    public function storeExample(Request $request)
    {

        // dd($request->json()->all());

        $recipe = Recipe::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'ingredients' => json_encode($request->input('ingredients')),
            'instructions' => json_encode($request->input('instructions'))
        ]);

        // return back();
    }

    public function index()
    {
        $recipes = Recipe::all();
        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function show($id)
    {
        $recipe = Recipe::find($id);
        $recipe->decodedIngredients = json_decode($recipe->ingredients);
        $recipe->decodedInstructions = json_decode($recipe->instructions);
        // dd($recipe->decodedIngredients);
        return view('recipes.show', compact('recipe'));
    }
}
