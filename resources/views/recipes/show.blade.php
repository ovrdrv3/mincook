@extends('layouts.app')

@section('content')
<div id="app" class="container my-5">
  <h1 class="primary-font dark-purple">{{ $recipe->name }}</h1>
  <br>
  <h3 class="dark-purple">Ingredients:</h3>

  @foreach ($recipe->ingredients as $ingredient)
  <div class="row text-large">

    <div class="col-4 mb-3 dark-purple" style="text-align: right;">
      {{ $ingredient->amount }}
    </div>

    <div class="col-8 mb-3 dark-purple">
      {{ $ingredient->food }}
    </div>

  </div>
  @endforeach

  <br>
  <h3 class="dark-purple">Instructions:</h3>

  @foreach ($recipe->instructions as $instruction)
  <div class="row text-large">

    <div class="col mb-3 dark-purple">
      {{ $instruction->do }}
    </div>

  </div>
  @endforeach
</div>

@endsection
