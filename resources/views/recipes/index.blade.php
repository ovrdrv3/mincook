@extends('layouts.app')

@section('content')
<div id="app" class="container my-5">
  <h1 class="primary-font dark-purple">All Recipes</h1>

  @foreach ($recipes as $recipe)
    <div class="recipe-item">
        <a href="/recipe/{{ $recipe->id }}">
            <div>
                {{ $recipe->name }}
            </div>
        </a>
    </div>
  @endforeach

</div>

@endsection
