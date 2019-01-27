@extends('layouts.app')

@section('content')
<div id="app" class="container my-5">
  <h1 class="primary-font dark-purple">All Recipes</h1>

  @foreach ($recipes as $recipe)
    <div class="recipe-item">
          <a href="/recipe/{{ $recipe->id }}">
        <div class="row">
            <div class="col-8">
                    {{ $recipe->name }}
            </div>
            <div class="col-4">
              <img src="{{ $recipe->imageUrl }}" style="max-height: 130px;" class="rounded img-fluid float-right">
              {{-- <img src="{{$recipe->imageUrl}}"></img> --}}
            </div>
        </div>
          </a>
    </div>
  @endforeach

</div>

@endsection
