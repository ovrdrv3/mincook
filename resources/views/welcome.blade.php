@extends('layouts.app')

@section('content')
<h2 id="top-header" class="primary-font section">
    minimum
    <br>
    <span id="changing-text" class="slide-in-animation">cook</span>
  </h2>
  {{-- <hr class="dark-purple" style="border-top: 1px dotted; margin-top: 4px; margin-bottom: 4px;"> --}}
    <div class="row">
      <div class="section container">
        <p>
          Concise recipes. No stories.
        </p>
        <br>
        <p>
          We give special badges to: 
          <br>
            {{-- <a > recipes with ingredients already at home </a> --}}
          {{-- <br> --}}
            <a class="special-recipe-item" href="/recipes/under5"> recipes with 5 or less ingredients </a>
        </p>
        <br>
        <p><a class="" href="/recipes">browse all recipies</a></p>
      </div>
      </div>

<script>

let textArray = [ "ingredients", "space", "time", "money", "mess."];

var textToChange = document.getElementById("changing-text");

textToChange.addEventListener("animationiteration", setTextContent, false);
var currentIndex = 0;

function setTextContent(){
  textToChange.textContent = textArray[currentIndex++];
  if(currentIndex == textArray.length){currentIndex = 0}
}

</script>
@endsection
