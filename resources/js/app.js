require('./bootstrap');

window.Vue = require('vue');

/* ElementUI - Biblioteca para interfaz de usuario */
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en';
Vue.use(ElementUI, { locale });

/* EventBus - Biblioteca para la comunicación entre componentes */
export const EventBus = new Vue();
window.EventBus = EventBus;

/* SweetAlert2 - Biblioteca para ventanas emergentes */
import Swal from 'sweetalert2';
window.Swal = Swal;

$.extend(true, $.fn.datetimepicker.defaults, {
    icons: {
        time: 'far fa-clock',
        date: 'far fa-calendar',
        up: 'fas fa-arrow-up',
        down: 'fas fa-arrow-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right',
        today: 'fas fa-calendar-check',
        clear: 'far fa-trash-alt',
        close: 'far fa-times-circle'
    }
});

/* Componentes de la app */
Vue.component('App', require('./components/App').default);


import router from './routes.js'
const app = new Vue({
    el: '#app',
    router
});