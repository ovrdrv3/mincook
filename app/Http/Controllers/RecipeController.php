<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use App\Recipe;
use App\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    protected $fillable = [];

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    private function prepare_view_data($recipesToModify)
    {
        foreach ($recipesToModify as $recipe) {
            $all_images = json_decode($recipe->image);
            // Just grab the first image in the array for display
            $recipe->firstImage = $all_images[0];
            $recipe->imageUrl = Storage::url('cover_images/' . $recipe->firstImage);
            $count_of_spaces = substr_count($recipe->description, ' ');
            if ($count_of_spaces > 20 ) {
                // get the first 20 words of the description for the index
                preg_match("/(?:\w+(?:\W+|$)){0,20}/", $recipe->description, $matches);
                $recipe->short_description = $matches[0] . '...';
            } else {
                $recipe->short_description = $recipe->description;
            }
        }
        
        return $recipesToModify;
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'cookTime' => 'required',
            'prepTime' => 'required',
        ]);


        // The names of these photos should be stored as an array.
        $all_cover_images = [];
        // Handle Multiple File Upload
        if($request->hasFile('cover_images')){
            // Loop through all photos uploaded in request
            foreach ($request->cover_images as $image) {
                // Get filename with the extension
                $filenameWithExt = $image->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $image->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore= $filename.'_'.time().'.'.$extension;
                // Upload Image
                $image->storeAs('public/cover_images', $fileNameToStore);
                // Add the name of this file to the Cover Images Array
                array_push($all_cover_images, $fileNameToStore);
            }

        } else {
            array_push($all_cover_images, 'noimage.jpg');
        };

        $recipe = Recipe::create([
            'user_id' => auth()->id(),
            'name' => $request->input('name'),
            'vegetarian' => $request->input('vegetarian'),
            'vegan' => $request->input('vegan'),
            'description' => $request->input('description'),
            'cook_time' => $request->input('cookTime'),
            'prep_time' => $request->input('prepTime'),
            'ingredients' => $request->input('ingredients'),
            'ingredient_quantity' => $request->input('ingredientQuantity'),
            'instructions' => $request->input('instructions'),
            'image' => json_encode($all_cover_images)
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
    // public function image(Request $request)
    // {
    //     return view('recipes.imageupload');
    // }

    public function index()
    {
        $recipes = Recipe::all();
        $recipes = $this->prepare_view_data($recipes);
        $recipes->page_description = "all recipes";
        return view('recipes.index', compact('recipes'));
    }

    public function user_index($user)
    {
        $recipes = Recipe::all()->where('user_id', $user);
        $recipes->userName = User::find($user)->name;
        $recipes = $this->prepare_view_data($recipes);
        $recipes->page_description = "recipes by " . $recipes->userName;
        return view('recipes.index', compact('recipes'));
    }    

    public function index_under_5()
    {
        $recipes = Recipe::all()->where('ingredient_quantity', '<=', 5);
        $recipes = $this->prepare_view_data($recipes);
        $recipes->page_description = 'all recipes with less than 5 ingredients';
        return view('recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('recipes.create');
    }

    public function edit($id, User $user)
    {
        $recipe = Recipe::find($id);
        // dd(auth()->id());
        // figure this one out. Maybe we can use "can(user, edit) blade directive on the show.blade.php page"
         if (Gate::denies('update-recipe', $recipe)) {
             return back()->with('error', "You can not edit a recipe that isn't yours!");
         }
        // dd($recipe);
        // return $recipe;
        $recipe->prepTime = $recipe->prep_time;
        $recipe->cookTime = $recipe->cook_time;
        unset($recipe->cook_time);
        unset($recipe->prep_time);
        $recipe->ingredients = json_decode($recipe->ingredients);
        $recipe->instructions = json_decode($recipe->instructions);
        $image_URL_staging = [];
        foreach (json_decode($recipe->image) as $image) {
            array_push($image_URL_staging, Storage::url('cover_images/' . $image));
        }
        $recipe->imageUrls = $image_URL_staging;
        $recipe->containsCustomImage = $recipe->imageUrls[0] != "noimage.jpg";
        // return $recipe;
        return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'cookTime' => 'required',
            'prepTime' => 'required',
        ]);

        $recipe = Recipe::find($request->input('id'));

        $recipeContainsCustomImage = $recipe->image != "noimage.jpg";

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

            // if original item existed, delete it, use the new image as splash now.
            if ($recipeContainsCustomImage) {
                Storage::delete('public/cover_images/' . $recipe->image);
            }
        } else {
            // If original image provided, keep as is.
            if ($recipeContainsCustomImage) {
                $fileNameToStore = $recipe->image;
            } else {
                $fileNameToStore = 'noimage.jpg';
            }
        };


        $recipe->user_id = auth()->id();
        $recipe->name =  $request->input('name');
        $recipe->vegetarian =  $request->input('vegetarian');
        $recipe->vegan =  $request->input('vegan');
        $recipe->description =  $request->input('description');
        $recipe->cook_time =  $request->input('cookTime');
        $recipe->prep_time =  $request->input('prepTime');
        $recipe->ingredients =  $request->input('ingredients');
        $recipe->ingredient_quantity =  $request->input('ingredientQuantity');
        $recipe->instructions =  $request->input('instructions');
        $recipe->image =  $fileNameToStore;

        $recipe->save();

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
        // Session::flash('message', 'Successfully updated recipe!');
        return $recipe->path();
    }

    public function show(Recipe $recipe)
    {
        // return $recipe;
        // $recipe = Recipe::find($id);
        $recipe->ingredients = json_decode($recipe->ingredients);
        $recipe->instructions = json_decode($recipe->instructions);
        $image_URL_staging = [];
        $all_images = json_decode($recipe->image);
        $recipe->containsCustomImage = $all_images[0] != "noimage.jpg";
        foreach ($all_images as $image) {
            array_push($image_URL_staging, Storage::url('cover_images/' . $image));
        }
        $recipe->imageUrls = json_encode($image_URL_staging);

        // dd($recipe->imageUrls);


        // dd($recipe->decodedIngredients);
        return view('recipes.show', compact('recipe'));
    }

    public function delete(Recipe $recipe)
    {
        $all_images = json_decode($recipe->image);
        if ($all_images[0] != "noimage.jpg"){
            foreach ($all_images as $image) {
                Storage::delete('public/cover_images/' . $image);
            }
        }
        $recipe->delete();
        Session::flash('success', 'Successfully deleted recipe.');
        return redirect('recipes');
    }
}
