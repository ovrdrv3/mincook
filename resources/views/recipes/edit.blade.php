@extends('layouts.app')

@section('content')
<div id="app" class="container my-5">
  <recipe-form :recipe="{{$recipe}}"></recipe-form>
</div>
@endsection
