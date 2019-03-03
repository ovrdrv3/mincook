<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingredient;

class IngredientController extends Controller
{
    //
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('ingredients.index', compact('ingredients'));
    }

    public function show($id)
    {
        $ingredient = Ingredient::find($id);
        $recipes = $ingredient->recipes;
        return view('recipes.index', compact('recipes'));
    }
}
