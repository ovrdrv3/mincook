@extends('layouts.app')

@section('content')
<div id="app" class="container my-5">
  <h1 class="primary-font dark-purple">{{ $recipe->name }}</h1>
    @if ($recipe->containsCustomImage)
    <div class="row text-large">
      <div class="col-lg-4" style="">
        {{ $recipe->description }}
        <hr>
        <span class="dark-purple">Prep Time</span>
        {{ $recipe->prep_time }}
        <br>
        <span class="dark-purple">Cook Time</span>
        {{ $recipe->cook_time }}
        <br>
        <span class="dark-purple">Vegetarian</span>
        @if ($recipe->vegetarian)
          &#x2714;
        @else
          &#x2716;
        @endif
        <br>
        <span class="dark-purple">Vegan</span>
        @if ($recipe->vegan)
            &#x2714;
        @else
          &#x2716;
        @endif

      </div>


        <div class="col-lg-8">
{{--           @foreach ($recipe->imageUrls as $imageUrl)
            <img src="{{ $imageUrl }}"  class="rounded img-fluid float-right mb-3">
          @endforeach --}}
          <image-slider :images="{{$recipe->imageUrls}}" style="max-height: 800px;" class="rounded img-fluid mb-3"></image-slider>
        </div>
    </div>
      @else
      {{-- No height styling brought in --}}
      <div class="row text-large">
        <div class="col-lg-4" style="">
          {{ $recipe->description }}
          <hr>
          <span class="dark-purple">Prep Time</span>
          {{ $recipe->prep_time }}
          <br>
          <span class="dark-purple">Cook Time</span>
          {{ $recipe->cook_time }}
          <br>
          <span class="dark-purple">Vegetarian</span>
          @if ($recipe->vegetarian)
            &#x2714;
          @else
            &#x2716;
          @endif
          <br>
          <span class="dark-purple">Vegan</span>
          @if ($recipe->vegan)
            &#x2714;
          @else
            &#x2716;
          @endif

        </div>
      </div>
      @endif


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
    @if (!$loop->last)
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
  <br>
  <div class="row text-large">

    @if(Gate::allows('update-recipe', $recipe))
      <div class="col mb-3">
        <a href="/editrecipe/{{$recipe->id}}">Edit this recipe?</a>
      </div>
      <br>
      <div class="col mb-3">
        <a href="/deleterecipe/{{$recipe->id}}">Delete this recipe?</a>
      </div>
    @endif

  </div>

</div>


@endsection
