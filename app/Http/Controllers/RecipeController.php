<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;

class RecipeController extends Controller
{
    protected $fillable = [];

    public function storeExample(Request $request)
    {

        // dd($request);

        // Handle File Upload
        if($request->hasFile('cover_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        };

        $recipe = Recipe::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'ingredients' => $request->input('ingredients'),
            'instructions' => $request->input('instructions'),
            'image' => $fileNameToStore
        ]);

        return $recipe;

        // return back();
    }
    public function image(Request $request)
    {
        return view('recipes.imageupload');
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
        $recipe->ingredients = json_decode($recipe->ingredients);
        $recipe->instructions = json_decode($recipe->instructions);

        // dd($recipe->decodedIngredients);
        return view('recipes.show', compact('recipe'));
    }
}
