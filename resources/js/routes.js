import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

/* function accessVerification(to, from, next, permission) {
    const authUser = JSON.parse(sessionStorage.getItem('authUser'));
    if(authUser) {
        const userPermissions = JSON.parse(sessionStorage.getItem('listPermissionsByAuthUser'));
        if(userPermissions.includes(permission)) {
            next();
        }else {
            next(from.path != '/' ? from.path : '/home');
        }
    }
} */

export const routes = [{
        path: '/home',
        name: 'home',
        component: require('./components/dashboard/HomeComponent').default
    },

    {
        path: '/ingredients',
        name: 'ingredients',
        component: require('./components/modules/ingredients/IngredientsComponent').default
    },

    {
        path: '/pizzas',
        name: 'pizzas',
        component: require('./components/modules/pizzas/PizzasComponent').default
    },
    /* {
        path: '/users',
        name: 'users',
        component: require('./components/modules/user/UserListComponent').default,
        beforeEnter: (to, from, next) => {
            accessVerification(to, from, next, 'users.index');
        },
    },
    {
        path: '/users/:id/profile/',
        name: 'profile',
        component: require('./components/modules/user/UserProfileComponent').default,
        props: true
    },
    {
        path: '/roles',
        name: 'roles',
        component: require('./components/modules/role/RoleListComponent.vue').default,
        beforeEnter: (to, from, next) => {
            accessVerification(to, from, next, 'roles.index');
        }
    }, */



    {
        path: '*',
        component: require('./components/layouts/404').default
    },
];

export default new Router({
    routes: routes,
    mode: 'history'
});
