import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

function accessVerification(to, from, next) {
    const authUser = JSON.parse(localStorage.getItem('authUser'));
    if (authUser) {
        next();
    } else {
        next(from.path != '/' ? from.path : '/home');
    }
}

export const routes = [{
        path: '/home',
        name: 'home',
        component: require('./components/dashboard/HomeComponent').default
    },
    {
        path: '/ingredients',
        name: 'ingredients',
        component: require('./components/modules/ingredients/IngredientsComponent').default,
        beforeEnter: (to, from, next) => {
            accessVerification(to, from, next);
        },
    },
    {
        path: '/pizzas',
        name: 'pizzas',
        component: require('./components/modules/pizzas/PizzasComponent').default,
        beforeEnter: (to, from, next) => {
            accessVerification(to, from, next);
        },
    },
    {
        path: '/orders',
        name: 'orders',
        component: require('./components/modules/orders/OrdersComponent').default,
        beforeEnter: (to, from, next) => {
            accessVerification(to, from, next);
        },
    },



    {
        path: '*',
        component: require('./components/layouts/404').default
    },
];

export default new Router({
    routes: routes,
    mode: 'history'
});