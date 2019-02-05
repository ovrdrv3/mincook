@extends('layouts.app')

@section('content')
<div id="app" class="container my-5">
  <h1 class="primary-font dark-purple">{{ $recipe->name }}</h1>
    <div class="row text-large">
      <div class="col-lg-4" style="">
        {{ $recipe->description }}
        <hr>
        <span class="dark-purple">Prep Time</span>
        {{ $recipe->prep_time }}
        <br>
        <span class="dark-purple">Cook Time</span>
        {{ $recipe->cook_time }}
      </div>

      @if ($recipe->containsCustomImage)
        <div class="col-lg-8 pull-right">
          <img src="{{ $recipe->imageUrl }}" style="max-height: 800px;" class="rounded img-fluid float-right">
        </div>
      @endif

    </div>
  <br>
  <br>
  <h2 class="">Ingredients:</h2>

  @foreach ($recipe->ingredients as $ingredient)
    <div class="row text-large">

      <div class="col-4 col-lg-3 text-right">
        {{ $ingredient->amount }}

      </div>

      <div class="col-8 col-lg-9">
        {{ $ingredient->food }}
      </div>
    </div>
    @if ($loop->last)
    @else
        <hr class="dark-purple" style="border-top: dotted 1px;margin-top: 4px; margin-bottom: 4px;">
    @endif
  @endforeach

  <br>
  <h2 class="">Instructions:</h2>

  @foreach ($recipe->instructions as $instruction)
  <div class="row text-large">

    <div class="col mb-3">
      {{ $instruction->do }}
    </div>

  </div>
  @endforeach
</div>

@endsection
