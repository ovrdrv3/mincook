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
            'instructions' => json_encode($request->input('instructions'))
        ]);

        // return back();
    }
}
