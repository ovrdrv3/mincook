@extends('layouts.app')

@section('content')
<div id="app" class="container my-5">
  <h1 class="primary-font dark-purple">All Recipes</h1>
  <br>
  <div class="row">
  @foreach ($recipes as $recipe)
    @if ($loop->index % 3 == 0 )
    @endif
      <div class="col-md-4">
        <div class="card mb-4 recipe-item">
          <img src="{{ $recipe->imageUrl }}" class="rounded" style="height: 225px;">
          <div class="card-body">
            <a href="/recipe/{{ $recipe->id }}">
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


@endsection
