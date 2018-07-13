require('./bootstrap');

window.Vue = require('vue');
import { library } from '@fortawesome/fontawesome-svg-core';
import { faArrowUp } from '@fortawesome/free-solid-svg-icons';
import { faArrowDown } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faTrash } from '@fortawesome/free-solid-svg-icons';

library.add(faArrowUp, faArrowDown, faTrash);

Vue.component('font-awesome-icon', FontAwesomeIcon);

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
          this.$nextTick(function () {
            // Code that will run only after the
            // entire view has been rendered
            this.$refs.step[this.$refs.step.length - 1].focus();
          })
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
          this.recipe[objectKey].splice(index, 1);
          this.reInitializeSort(objectKey);
          // focus on the closest element
          if (this.$refs.step.length -1 == index ) {
            this.$refs.step[index - 1].focus();
          } else {
            this.$refs.step[index].focus();
          }
        },
        removeStepWithBackspace(objectKey, index){
          if (this.recipe[objectKey][index].do == ""){
            this.removeStep(objectKey, index);
          }
        },
        reInitializeSort(objectKey){
          this.recipe[objectKey].forEach(function(el, i){
            // re-init the values of sort
              el.sort = i + 1;
          });
        }
    }
});
