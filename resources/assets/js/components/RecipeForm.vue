<template>
<div>
  <h1 class="primary-font dark-purple">Add a new recipe</h1>

  <div class="form-group">
      <input class="form-control" placeholder="Name" v-model="recipe.name">
  </div>

  <div class="form-group">
      <textarea class="form-control" placeholder="Description" v-model="recipe.description"></textarea>
  </div>

  <h2 class="primary-font dark-purple">Photo</h2>
  <div class="form-group">
    <input type="file" class="form-control" v-on:change="onImageChange">
  </div>
  <div id="preview">
    <img v-if="tempImageURL" :src="tempImageURL" class="rounded img-fluid"/>
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

</template>
<script>
    export default {
    data() {
      return {
        recipe: {
            name: '',
            description: '',
            ingredients: [{amount: '' , food: ''}],
            instructions: [{sort: 1, do: ''}]
        },
        image: null,
        tempImageURL: null
      }
    },
    methods: {
        addRecipe(e) {
                e.preventDefault();
                let currentObj = this;

                let formData = new FormData();
                formData.append('cover_image', this.image);
                formData.append('name', this.recipe.name);
                formData.append('description', this.recipe.description);
                formData.append('ingredients', JSON.stringify(this.recipe.ingredients));
                formData.append('instructions', JSON.stringify(this.recipe.instructions));

                axios.post('/saverecipe', formData, {
                    headers: { 'content-type': 'multipart/form-data' }
                })
                .then(function (response) {
                    currentObj.success = response.data.success;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
        },
        onImageChange(e){
            // console.log(e.target.files[0]);
            this.image = e.target.files[0];
            this.tempImageURL = URL.createObjectURL(this.image);
        },
        addInstruction(focusOnLastElement){
          // Create the new object to append to the instructions array
          var newObject = {"do" : "" };
          this.recipe.instructions.push(newObject);
          if (focusOnLastElement) {
            this.$nextTick(function () {
              // Code that will run only after the
              // entire view has been rendered
              this.$refs.step[this.$refs.step.length - 1].focus();
            })
          }
        },
        addIngredient(focusOnLastElement){
          // Create the new object to append to the instructions array
          var newObject = {"amount" : "",
                           "food" : "" };
          this.recipe.ingredients.push(newObject);
          if (focusOnLastElement) {
            this.$nextTick(function () {
              // Code that will run only after the
              // entire view has been rendered
              this.$refs.amount[this.$refs.amount.length - 1].focus();
            })
          }
        },
        shiftStepUp(objectKey, index){
          // store the value of the step that is going to be replaced
          // shift the step up one
          this.recipe[objectKey].splice(index - 1, 2, this.recipe[objectKey][index], this.recipe[objectKey][index - 1]);
          this.reInitializeSort(objectKey);
        },
        shiftStepDown(objectKey, index){
          this.recipe[objectKey].splice(index, 2, this.recipe[objectKey][index + 1], this.recipe[objectKey][index]);
          this.reInitializeSort(objectKey);
        },
        removeStep(objectKey, index){
          if (this.recipe[objectKey].length > 1) {
            this.recipe[objectKey].splice(index, 1);
            this.reInitializeSort(objectKey);
            this.focusOnRef(objectKey, index);
          }
        },
        removeStepWithBackspace(objectKey, index){
          if(objectKey == 'ingredients'){
            if (this.recipe[objectKey][index].amount == "" && this.recipe[objectKey][index].food == ""){
              this.removeStep(objectKey, index);
            }
          }
          if(objectKey == 'instructions'){
            if (this.recipe[objectKey][index].do == ""){
              this.removeStep(objectKey, index);
            }
          }
        },
        focusOnRef(objectKey, index){
          // focus on the closest element
          if(objectKey == 'ingredients') {
            if (this.$refs.ingredient.length - 1 == index ) {
              this.$refs.ingredient[index - 1].focus();
            } else {
              this.$refs.ingredient[index].focus();
            }
          }
          if(objectKey == 'instructions') {
            if (this.$refs.step.length - 1 == index ) {
              this.$refs.step[index - 1].focus();
            } else {
              this.$refs.step[index].focus();
            }
          }
        },
        reInitializeSort(objectKey){
          this.recipe[objectKey].forEach(function(el, i){
            // re-init the values of sort
              el.sort = i + 1;
          });
        }
    }
}

</script>
