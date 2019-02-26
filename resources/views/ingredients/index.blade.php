@extends('layouts.app')

@section('content')
<div id="app" class="container my-5">
  <h1 class="primary-font dark-purple">All Ingredients</h1>
  <br>

  @foreach ($ingredients as $ingredient)
    <div class="row">

      <a href="/ingredient/{{ $ingredient->id }}">
      <h4 class="light-purple">{{ $ingredient->name }}</h4>
      </a>
      <br>

    </div>
  @endforeach


@endsection
