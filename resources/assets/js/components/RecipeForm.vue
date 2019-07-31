<template>
<div>
  <h1 class="primary-font dark-purple"><span v-if="recipe.originalRecipe">Add a new recipe</span><span v-else>Edit recipe</span></h1>

  <div class="form-group">
      <input class="form-control" :class="{ 'is-invalid': errors.name && !recipe.name }" placeholder="Name" v-model="recipe.name">
      <div v-if="errors.name && !recipe.name" class="dark-purple form-text is-invalid">{{errors.name}}</div>
  </div>

  <div class="form-group">
      <textarea class="form-control" placeholder="Description" v-model="recipe.description"></textarea>
  </div>

  <div class="form-group">
      <input class="form-control" :class="{ 'is-invalid': errors.cookTime && !recipe.cookTime }" placeholder="Cook Time" v-model="recipe.cookTime">
      <div v-if="errors.cookTime && !recipe.cookTime" class="dark-purple form-text is-invalid">{{errors.cookTime}}</div>
  </div>

  <div class="form-group">
      <input class="form-control" :class="{ 'is-invalid': errors.prepTime && !recipe.prepTime }" placeholder="Prep Time" v-model="recipe.prepTime">
      <div v-if="errors.prepTime && !recipe.prepTime" class="dark-purple form-text is-invalid">{{errors.prepTime}}</div>
  </div>

  <h2 class="primary-font dark-purple">Photos</h2>
  <div v-if="recipe.originalRecipe">
    <div class="form-group">
      <input type="file" class="form-control" v-on:change="onImageChange" multiple>
    </div>
    <div id="preview">
      <img v-for="image in tempImageURLList" :src="image" class="rounded img-fluid mb-3"/>
      <img v-if="recipe.imageUrl && !tempImageURLList" :src="recipe.imageUrl" class="rounded img-fluid"/>
    </div>
  </div>
  <div v-else>
    <div id="preview">
      <img v-for="image in recipe.imageUrls" :src="image" class="rounded img-fluid mb-3"/>
    </div>
    <h2 class="primary-font dark-purple">Want different photos? Delete this recipe and start from scratch!</h2>
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
        type="text" class="form-control"
        :placeholder="'# ' + (index + 1) + ' Food'"
        :class="{ 'is-invalid': errors.ingredients && !recipe.ingredients[index].food }"
        required>
      </div>
      <div v-if="errors.ingredients && !recipe.ingredients[index].food" class="dark-purple form-text is-invalid">{{errors.ingredients}}</div>
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
        rows="3"
        :class="{ 'is-invalid': errors.instructions && !recipe.instructions[index].do }"
        required></textarea>
      </div>
      <div v-if="errors.instructions && !recipe.instructions[index].do" class="dark-purple form-text is-invalid">{{errors.instructions}}</div>
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
      <button class="form-control" @click="addRecipe">{{errorsPresent}}</button>
  </div>

</div>

</template>
<script>
    export default {
    props: {
      // Object with a default value
      recipe: {
        type: Object,
        // Object or array defaults must be returned from
        // a factory function
        default: function () {
          return {
            name: '',
            description: '',
            prepTime: '',
            cookTime: '',
            ingredients: [{amount: '' , food: ''}],
            instructions: [{sort: 1, do: ''}],
            originalRecipe: true
          }
        }
      }
    },
    computed:{
      errorsPresent () {
        if (this.submissionAttempt) {
          this.formValidation();
        }
        for (var key in this.errors) {
            // skip loop if the property is from prototype
            if (!this.errors.hasOwnProperty(key)) continue;
            // if there are any error messages present we want to return a condition of true
            if (this.errors[key]) return 'Check above for errors - You may have missed something important!';
        }
        // Making it out of this loop would represent no errors found.
        return 'Submit';
      }
    },
    data() {
      return {
        recipe: this.recipe,
        images: [],
        numberOfImages: 0,
        tempImageURLList: [],
        submissionAttempt : false,
        errors: {
          'name': '',
          'prepTime': '',
          'cookTime': '',
          'ingredients': '',
          'instructions': '',
          'any' : false
        }
      }
    },
    methods: {
        addRecipe(e) {
                e.preventDefault();
                let currentObj = this;
                this.submissionAttempt = true;

                var readyToProceed = this.formValidation();
                if (!readyToProceed) { return; }

                let formData = new FormData();
                // Handle Multiple Image Upload
                let i = 0;
                Array.from(this.images).forEach(file => {
                  formData.append('cover_images[' + i++ + ']', file)
                });
                // formData.append('cover_images', this.images);
                formData.append('name', this.recipe.name);
                formData.append('prepTime', this.recipe.prepTime);
                formData.append('cookTime', this.recipe.cookTime);
                formData.append('description', this.recipe.description);
                formData.append('ingredients', JSON.stringify(this.recipe.ingredients));
                formData.append('instructions', JSON.stringify(this.recipe.instructions));

                // create POST Link - save or edit recipe?
                if (this.recipe.originalRecipe) {
                  axios.post('/saverecipe', formData, {
                      headers: { 'content-type': 'multipart/form-data' }
                  })
                  .then(function (response) {
                      console.log(response.data);
                      window.location.href = response.data;
                      currentObj.success = response.data.success;
                  })
                  .catch(function (error) {
                      let validationMessages = error.response.data.errors;
                      for (var message in validationMessages) {
                          currentObj.errors[message] = 'Oops! ' + validationMessages[message];
                      }
                  });
                } else {
                  formData.append('id', JSON.stringify(this.recipe.id));
                  formData.append('_method', 'PATCH'); // https://laravel.com/docs/5.8/routing#form-method-spoofing

                  axios.post('/editrecipe/' + this.recipe.id, formData, {
                      headers: { 'content-type': 'multipart/form-data' }
                  })
                  .then(function (response) {
                      console.log(response.data);
                      window.location.href = response.data;
                      currentObj.success = response.data.success;
                  })
                  .catch(function (error) {
                      let validationMessages = error.response.data.errors;
                      for (var message in validationMessages) {
                          currentObj.errors[message] = 'Oops! ' + validationMessages[message];
                      }
                  });
                }

        },
        formValidation(){
          // some quick front end validation for the fields
          this.errors.any = false;
          // Reset error fields
          for(var field in this.errors){
            this.errors[field] = '';
          }
          if(this.recipe.name == '' || this.recipe.prepTime == '' || this.recipe.cookTime == ''){
            for(var field in this.recipe){
              if(this.recipe[field] == ''){
                if (field == 'prepTime') {
                  this.errors[field] = 'Oops! The Prep Time field is required.';
                }
                if (field == 'cookTime') {
                  this.errors[field] = 'Oops! The Cook Time field is required.';
                }
                if (field == 'name') {
                  this.errors[field] = 'Oops! The Name field is required.';
              }
                this.errors.any = true;
              }
            }
          }
          for(var ingredient in this.recipe.ingredients){
            if(this.recipe.ingredients[ingredient].food == ''){
              this.errors.ingredients = 'Empty ingredient field!';
              this.errors.any = true;
            }
          }
          for(var instruction in this.recipe.instructions){
            if(this.recipe.instructions[instruction].do == ''){
              this.errors.instructions = 'Empty instruction!';
              this.errors.any = true;
            }
          }
          if (this.errors.any) {
            // console.log('errors found.');
            return false;
          };
          return true;
        },
        onImageChange(e){
            // console.log(e.target.files[0]);
            this.images = e.target.files;
            Array.from(this.images).forEach(file => {
              this.tempImageURLList.push(URL.createObjectURL(file))
              // console.log(file);
            });
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
