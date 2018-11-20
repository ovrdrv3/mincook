require('./bootstrap');

window.Vue = require('vue');
import { library } from '@fortawesome/fontawesome-svg-core';
import { faArrowUp } from '@fortawesome/free-solid-svg-icons';
import { faArrowDown } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faTrash } from '@fortawesome/free-solid-svg-icons';

library.add(faArrowUp, faArrowDown, faTrash);

Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('recipe-form',require('./components/RecipeForm.vue'));

const app = new Vue({
    el: '#app'
});


