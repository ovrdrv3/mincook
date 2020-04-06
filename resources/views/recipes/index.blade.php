@extends('layouts.app')

@section('content')
<div class="container my-5">
  <h1 class="primary-font dark-purple">{{ $recipes->page_description}}</h1>
  <br>
  <div class="row">
  @foreach ($recipes as $recipe)
      <div class="col-md-4">
        @if ($recipe->ingredient_quantity <= 5)
          <div class="card mb-4 special-recipe-item">
        @else  
          <div class="card mb-4 recipe-item">
        @endif
          <img src="{{ $recipe->imageUrl }}" class="rounded" style="height: 300px; object-fit: cover;">
          <div class="card-body">
            <a href="{{ $recipe->path() }}">
              <h4 class="light-purple">{{ $recipe->name }}</h4>
            </a>
            <small class="text-small light-purple">{{ $recipe->short_description }}</small>
          </div>
        </div>
      </div>
    @if ($loop->iteration % 3 == 0 && !$loop->last )
    </div>
    <div class="row">
    @endif
  @endforeach
  </div>
  </div>


@endsection
