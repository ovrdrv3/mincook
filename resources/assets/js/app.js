
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
        ingredients: '',
        instructions: [{sort: '', amount: '', do: ''}]
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
            ingredients: '',
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
        }
    }
});
