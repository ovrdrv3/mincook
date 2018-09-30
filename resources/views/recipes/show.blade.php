@extends('layouts.app')

@section('content')
<div id="app" class="container my-5">
  <h1 class="primary-font dark-purple">This is the page for {{ $recipe->name }}</h1>
  <br>
  <h3 class="dark-purple">Ingredients:</h3>

  @foreach ($recipe->decodedIngredients as $ingredient)
  <div class="row">

    <div class="col-md-2 mb-3 dark-purple" style="text-align: right;">
      {{ $ingredient->amount }}
    </div>

    <div class="col-md-10 mb-3 dark-purple">
      {{ $ingredient->food }}
    </div>

  </div>
  @endforeach

  <br>
  <h3 class="dark-purple">Instructions:</h3>

  @foreach ($recipe->decodedInstructions as $instruction)
  <div class="row">

    <div class="col-md-10 mb-3 dark-purple">
      {{ $instruction->do }}
    </div>

  </div>
  @endforeach

@endsection
