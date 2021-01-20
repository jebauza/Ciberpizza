require('./bootstrap');

window.Vue = require('vue');

/* Componentes de la app */
Vue.component('App', require('./components/App').default);


import router from './routes.js'
const app = new Vue({
    el: '#app',
    router
});
