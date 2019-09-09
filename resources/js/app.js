require('./bootstrap');

window.Vue = require('vue');

Vue.component('counter', require('./components/Counter.vue').default);

const app = new Vue({
    el: '#app',
});
