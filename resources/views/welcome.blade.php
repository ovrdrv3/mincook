@extends('layouts.app')

@section('content')
<h1 id="top-header" class="primary-font section">
    minimal
    <br>
    <span id="changing-text" class="slide-in-animation">cook</span>
  </h1>
    <div class="row">
      <div class="section col-md-5">
        <H2 class="primary-font">Simple Cooking.</H2>
        <p>
          Hmm, a home-cooked meal would be nice tonight. You find a recipie that seems simple, but scroll down to find a huge list of ingredients, and a complex set of instructions. Please spend some time here, and I am sure you will agree that cooking can be simple.
        </p>
        <p><a class="" href="/recipes">browse recipies now</a></p>
      </div>
      <div class="section col-md-5 offset-md-2">
        <H2 class="primary-font">Solutions.</H2>
          <br>
          <p>
            Easy simple cooking, with a minimal amount of ingredients, cooking with one pan, bulk ingredients that won't go bad in your pantry. Does this sound good to you? This type of cooking is faster yet still tasty.
        </p>
      </div>
      <div class="section col-md-5 offset-md-2">
          <H2 class="primary-font">Problems.</H2>
          <br>
          <p>
            Maybe you never learned how to cook, spend too much money eating out, or have minimal access to a kitchen. Give your stove top (or hot plate) some life and see how quickly these problems are eased.
          </p>
      </div>
      <div class="section col-md-5 offset-md-2">
          <H2 class="primary-font">Technique.</H2>
          <br>
          <p>
            Want to cut your food prep time? Want your greens to look fancy instead of crumbled up? Improve on a few of your techniques and you'll have good looking plates in no time.
          </p>
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
k
@endsection
