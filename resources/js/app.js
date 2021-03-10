require('./bootstrap');

window.Vue = require('vue');

Vue.component('profile-user-component', require('./components/ProfileUserComponent.vue'));


const app = new Vue({
    el: '#app',
});
