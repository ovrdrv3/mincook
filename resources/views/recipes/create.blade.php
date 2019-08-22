@extends('layouts.app')

@section('content')
<div id="app" class="container my-5">
  <recipe-form :userid="{{ Auth::user()->id }}"></recipe-form>
  {{-- <recipe-form></recipe-form> --}}
</div>
@endsection
