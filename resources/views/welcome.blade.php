@extends('layouts.app')

@section('content')
<h1 id="top-header" class="primary-font section">
    minimum
    <br>
    <span id="changing-text" class="slide-in-animation">cook</span>
  </h1>
  <hr class="dark-purple" style="border-top: 1px dotted; margin-top: 4px; margin-bottom: 4px;">
    <div class="row">
      <div class="section container">
        <p>
          No, I do not want to read how your great-aunt used to make <a href="http://mincook.test/recipe/1">Good Stuff</a>. I want to cook. If you do too, welcome. You've come to the right place.
        </p>
        <br>
        <p>
          We give special badges to recipes with ingredients already at home or 5 or less ingredients.
        </p>
        <br>
        <p><a class="" href="/recipes">browse recipies now</a></p>
      </div>
      </div>
  <footer class="pt-4 my-md-5 pt-md-5 border-top light-purple">
    <div class="container">
          <div class="row">
            <div class="col-12 col-md">
        <h2 class="primary-font">minimal <br> cook </h2>
            </div>
            <div class="col-6 col-md">
              <h5>Features</h5>
              <ul class="list-unstyled text-small">
                <li><a class="" href="#">Cool stuff</a></li>
                <li><a class="" href="#">Random feature</a></li>
                <li><a class="" href="#">Team feature</a></li>
              </ul>
            </div>
            <div class="col-6 col-md">
              <h5>Resources</h5>
              <ul class="list-unstyled text-small">
                <li><a class="" href="#">Resource</a></li>
                <li><a class="" href="#">Resource name</a></li>
                <li><a class="" href="#">Another resource</a></li>
                <li><a class="" href="#">Final resource</a></li>
              </ul>
            </div>
            <div class="col-6 col-md">
              <h5>About</h5>
              <ul class="list-unstyled text-small">
                <li><a class="" href="#">Team</a></li>
                <li><a class="" href="#">Locations</a></li>
                <li><a class="" href="#">Privacy</a></li>
                <li><a class="" href="#">Terms</a></li>
              </ul>
            </div>
      </div>
      <div class="row">
        <div class="col-12 col-md">
          <small class="d-block mb-3 ">Developed by Donaven Snowden © 2018</small>
        </div>
      </div>
      </div>
    </footer>







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
