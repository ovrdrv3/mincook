
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
var store = {
  debug: true,
  recipe: {
        name: '',
        description: '',
        ingredients: [{amount: '' , food: ''}],
        instructions: [{sort: '', do: ''}]
  },
  setMessageAction (newValue) {
    if (this.debug) console.log('setMessageAction triggered with', newValue)
    this.state.message = newValue
  },
  clearMessageAction () {
    if (this.debug) console.log('clearMessageAction triggered')
    this.state.message = ''
  }
}

const app = new Vue({
    el: '#app',
    data: {
        recipe:{
            name: '',
            description: '',
            ingredients: [{amount: '' , food: ''}],
            instructions: [{sort: 1, do: ''}]
        }
    },
    methods: {
        addRecipe() {
            axios.post('/saverecipe', this.recipe);
        },
        addInstruction(){
          // Create the new object to append to the instructions array
          var newObject = {"sort" : this.recipe.instructions.length + 1,
                           "do" : "" };
          this.recipe.instructions.push(newObject);
        },
        shiftStepUp(index){
          // assign new sort order of the objects
          this.recipe.instructions[index - 2].sort = index ;
          this.recipe.instructions[index - 1].sort = index - 1;

          // store the value of the step that is going to be replaced
          var savedLine = this.recipe.instructions[index - 2];
          // shift the array[step] up one
          this.recipe.instructions.splice(index - 2, 2, this.recipe.instructions[index - 1]);
          // put the original back
          this.recipe.instructions.splice(index - 1, 0, savedLine);
        },
        shiftStepDown(index){
          this.recipe.instructions[index].sort = index;
          this.recipe.instructions[index - 1].sort = index + 1;
          var savedLine = this.recipe.instructions[index];
          this.recipe.instructions.splice(index - 1 , 2, this.recipe.instructions[index - 1]);
          this.recipe.instructions.splice(index - 1, 0, savedLine);
        },
        removeStep(sortValue){
          this.recipe.instructions.splice(sortValue - 1, 1);
          this.recipe.instructions.forEach(function(el, i){
            // re-init the values of sort
              el.sort = i + 1;
          });
        }
    }
});
