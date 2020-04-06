@extends('layouts.app')

@section('content')
<div class="container my-5">
  <h1 class="primary-font dark-purple">Find Recipes by Ingredient!</h1>
  <br>

  @foreach ($ingredients as $ingredient)
    <div class="row">

      <a href="/ingredient/{{ $ingredient->id }}">
      <h4 class="light-purple">{{ $ingredient->name }}</h4>
      </a>
      <br>

    </div>
  @endforeach

</div>

@endsection
