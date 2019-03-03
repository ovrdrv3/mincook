<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Recipe;
use App\Ingredient;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    protected $fillable = [];

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'cookTime' => 'required',
            'prepTime' => 'required',
        ]);

        // Handle File Upload
        if($request->hasFile('cover_image') && $request->file('cover_image')->isValid()){
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
            'cook_time' => $request->input('cookTime'),
            'prep_time' => $request->input('prepTime'),
            'ingredients' => $request->input('ingredients'),
            'instructions' => $request->input('instructions'),
            'image' => $fileNameToStore
        ]);

        // Add all of the ingredients to the ingredients table and link them to this recipe's ID.
        $ingredients_for_pivot = json_decode($request->input('ingredients'));
        foreach ($ingredients_for_pivot as $ingredient) {
            // TODO fix this later once we are able to add vegetarian option to the JSON
            $new_ingredient = Ingredient::firstOrCreate([
                'name' => $ingredient->food,
                'vegetarian' => false
            ]);
            // Add to pivot table
            $recipe->ingredients()->attach($new_ingredient->id);
        }

        return $recipe->path();

        // return back();
    }
    public function image(Request $request)
    {
        return view('recipes.imageupload');
    }

    public function index()
    {
        $recipes = Recipe::all();
        foreach ($recipes as $recipe) {
            $recipe->imageUrl = Storage::url('cover_images/' . $recipe->image);
            $count_of_spaces = substr_count($recipe->description, ' ');
            if ($count_of_spaces > 20 ) {
                // get the first 20 words of the description for the index
                preg_match("/(?:\w+(?:\W+|$)){0,20}/", $recipe->description, $matches);
                $recipe->short_description = $matches[0] . '...';
            } else {
                $recipe->short_description = $recipe->description;
            }
        }
        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function edit($id)
    {
        $recipe = Recipe::find($id);
        // dd($recipe);
        // return $recipe;
        $recipe->prepTime = $recipe->prep_time;
        $recipe->cookTime = $recipe->cook_time;
        unset($recipe->cook_time);
        unset($recipe->prep_time);
        $recipe->ingredients = json_decode($recipe->ingredients);
        $recipe->instructions = json_decode($recipe->instructions);
        $recipe->containsCustomImage = $recipe->image != "noimage.jpg";
        $recipe->imageUrl = Storage::url('cover_images/' . $recipe->image);
        // return $recipe;
        return view('recipes.edit', compact('recipe'));
    }

    public function show($id)
    {
        $recipe = Recipe::find($id);
        $recipe->ingredients = json_decode($recipe->ingredients);
        $recipe->instructions = json_decode($recipe->instructions);
        $recipe->containsCustomImage = $recipe->image != "noimage.jpg";
        $recipe->imageUrl = Storage::url('cover_images/' . $recipe->image);


        // dd($recipe->decodedIngredients);
        return view('recipes.show', compact('recipe'));
    }
}
