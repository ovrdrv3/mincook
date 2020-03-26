@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="primary-font dark-purple">Dashboard</h1>
    {{-- <div class="card-body"> --}}
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    {{-- </div> --}}
    <br>
    {{-- <h2>You are logged in!</h2> --}}
    <p>Logged in as: {{ Auth::user()->name }}</p>
    <p><a href="/password/change">Change password</a></p>
    <p>
        <a href="{{ route('logout') }}"
        onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </p>
    {{-- <p><a class="" href="/recipes">Browse recipies now</a></p> --}}
</div>
@endsection
