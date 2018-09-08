@extends('layouts.app')

@section('content')
<div id="app" class="container my-5">
  <h1 class="primary-font dark-purple">Add a new recipe</h1>
  <div class="form-group">
      <input class="form-control" placeholder="Name" v-model="recipe.name">
  </div>
  <div class="form-group">
      <textarea class="form-control" placeholder="Description" v-model="recipe.description"></textarea>
  </div>

  <h2 class="primary-font dark-purple">Ingredients</h2>

  <div class="form-group">
      <button class="form-control" @click="addIngredient(false)">Add Ingredient</button>
  </div>

  <div class="form-row"
  v-for="(ingredient, index) in recipe.ingredients">

    <div class="col-md-2 mb-3">
      <label for="amount" v-show="index == 0">Amount</label>
      <input type="text"
      :ref="'amount'"
      @keydown.enter="$refs.ingredient[index].focus"
      @keyup.delete="removeStepWithBackspace('ingredients', index)"
      class="form-control" v-model="ingredient.amount" :placeholder="'# ' + (index + 1) + ' Amount'">
    </div>

    <div class="col-md-10 mb-3">
      <label for="food" v-show="index == 0">Food</label>
      <div class="input-group">
        <input
        @keydown.enter="addIngredient(true)"
        @keyup.delete="removeStepWithBackspace('ingredients', index)"
        :ref="'ingredient'"
        v-model="ingredient.food"
        type="text" class="form-control" :placeholder="'# ' + (index + 1) + ' Food'" required>
      </div>
    </div>
  </div>
  <hr>

  <h2 class="primary-font dark-purple">Instructions</h2>

  <div class="form-group">
      <button class="form-control" @click="addInstruction(false)">Add Step</button>
  </div>

  <div class="form-row"
  v-for="(instruction, index) in recipe.instructions">
    <div class="col-md-1 mb-3">
      <label for="sort" v-show="index == 0">Order</label>

      <input
      :value="index + 1"
      type="text" class="form-control" tabindex="-1" style="background-color:transparent; border: 0; font-size: 1em;" readonly>

    </div>
    <div class="col-md-10 mb-3">
      <label for="do" v-show="index == 0">Step</label>
      <div class="input-group">
        <textarea
        :ref="'step'"
        @keydown.enter="addInstruction(true)"
        @keyup.delete="removeStepWithBackspace('instructions', index)"
        v-model="instruction.do" class="form-control"
        rows="3" required></textarea>
      </div>
    </div>
    <div class="col-md-1 mb-3 center-text">
      <label for="buttons" v-show="index == 0">Change</label>
      <br v-if="index == 0">

      <font-awesome-icon icon="arrow-up" size="lg"
      v-if="index != 0"
      @click="shiftStepUp('instructions', index)"></font-awesome-icon>

      <font-awesome-icon icon="arrow-down" size="lg"
      v-if="index != recipe.instructions.length - 1"
      @click="shiftStepDown('instructions', index)"></font-awesome-icon>

      <font-awesome-icon icon="trash" size="lg"
      v-if="index != 0"
      @click="removeStep('instructions', index)"></font-awesome-icon>

    </div>
  </div>


  <div class="form-group">
      <button class="form-control" @click.prevent="addRecipe">Submit</button>
  </div>
</div>

@endsection
