<template>

    <nav class="navbar navbar-expand navbar-white navbar-dark navbar-gray">
        <!-- <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Prueba</a>
            </li>
        </ul> -->

        <ul class="navbar-nav">
            <li class="nav-item text-white">
                <h2>CiberPizza</h2>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">

            <template v-if="auth_user">
                <li class="nav-item d-none d-sm-inline-block">
                    <router-link :to="{path: 'pizzas'}" class="nav-link">CRUD Pizza</router-link>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <router-link :to="{path: 'ingredients'}" class="nav-link">CRUD Ingredientes</router-link>
                </li>
                <li class="nav-item dropdown ml-3">
                    <a data-toggle="dropdown" href="#" class="user-profile dropdown-toggle text-white" aria-expanded="false">
                        <img src="https://quepar.local/img/user-default.png" alt="Cinque Terre" class="rounded-circle" width="40" height="40">
                            <span class="text-white"> Jorge Ernesto</span>
                        </a>

                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="left: inherit; right: 0px;">
                        <a style="cursor:pointer" @click="logout()" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i> Salir
                        </a>
                    </div>
                </li>
            </template>
            <template v-else>
                <li class="nav-item d-none d-sm-inline-block" @click="showSignup()">
                    <a class="nav-link" style="cursor:pointer">Sign up</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block" @click="showLogin()">
                    <a class="nav-link" style="cursor:pointer">Login</a>
                </li>
            </template>


        </ul>

        <!-- Login -->
        <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Login</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form class="needs-validation" v-on:submit.prevent="sendLogin">
                        <div class="modal-body">

                            <div class="card-body login-card-body pt-0">
                                <div class="input-group mb-3">
                                    <input @keyup.enter="sendLogin" type="email" placeholder="Correo"
                                        v-model="loginForm.email" name="email"
                                        :class="['form-control', errors.email ? 'is-invalid' : '']"
                                        required autocomplete="email" autofocus>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                    <span v-if="errors.email" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.email[0] }}</strong>
                                    </span>
                                </div>
                                <div class="input-group mb-3">
                                    <input @keyup.enter="sendLogin" type="password" placeholder="Contraseña"
                                        v-model="loginForm.password" name="password"
                                        :class="['form-control', errors.password ? 'is-invalid' : '']"
                                        required autocomplete="current-password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                    <span v-if="errors.password" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.password[0] }}</strong>
                                    </span>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block" v-loading.fullscreen.lock="fullscreenLoading">Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Singup -->
        <div class="modal fade" id="modalSingup" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Singup</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form class="needs-validation" v-on:submit.prevent="sendSignup">
                        <div class="modal-body">

                            <div class="form-row">

                                <div class="form-group col-12">
                                    <label for="name" :class="['control-label', errors.name ? 'text-danger' : '']">Nombre</label>
                                    <input v-model="signupForm.name" type="text" :class="['form-control', errors.name ? 'is-invalid' : '']" name="name" placeholder="Nombre" required>
                                    <small v-if="errors.name" class="form-control-feedback text-danger">
                                        {{ errors.name[0] }}
                                    </small>
                                </div>
                                <div class="form-group col-12">
                                    <label for="last_name" :class="['control-label', errors.last_name ? 'text-danger' : '']">Apellidos</label>
                                    <input v-model="signupForm.last_name" :class="['form-control', errors.last_name ? 'is-invalid' : '']" name="last_name" required>
                                    <small v-if="errors.last_name" class="form-control-feedback text-danger">
                                        {{ errors.last_name[0] }}
                                    </small>
                                </div>
                                <div class="form-group col-12">
                                    <label for="email" :class="['control-label', errors.email ? 'text-danger' : '']">Email</label>
                                    <input v-model="signupForm.email" :class="['form-control', errors.email ? 'is-invalid' : '']" name="email" required>
                                    <small v-if="errors.email" class="form-control-feedback text-danger">
                                        {{ errors.email[0] }}
                                    </small>
                                </div>
                                <div class="form-group col-12">
                                    <label for="password" :class="['control-label', errors.password ? 'text-danger' : '']">Password</label>
                                    <input type="password" v-model="signupForm.password" :class="['form-control', errors.password ? 'is-invalid' : '']" name="password" required>
                                    <small v-if="errors.password" class="form-control-feedback text-danger">
                                        {{ errors.password[0] }}
                                    </small>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" v-loading.fullscreen.lock="fullscreenLoading">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </nav>

</template>

<script>
export default {
    props: ['basepath','auth_user'],
    mounted() {

    },
    data() {
        return {
            loginForm: {
                email: '',
                password: ''
            },
            signupForm: {
                name: '',
                last_name: '',
                email: '',
                password: ''
            },
            errors: {},

            fullscreenLoading: false
        }
    },
    methods: {
        showLogin() {
            this.erros = {};
            $('#modalSignup').modal('hide');
            $('#modalLogin').modal('show');
        },
        sendLogin() {
            this.fullscreenLoading = true;
            const url = '/api/auth/login';

            axios.post(url, this.loginForm)
            .then(res => {
                axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.access_token}`;
                localStorage.setItem('access_token', res.data.access_token);
                EventBus.$emit('verifyAuthenticatedUser');
                $('#modalLogin').modal('hide');
                this.fullscreenLoading = false;
            })
            .catch(err => {
                this.fullscreenLoading = false;
                this.errors = err.response.data.errors;
            });
        },
        showSignup() {
            this.erros = {};
            $('#modalLogin').modal('hide');
            $('#modalSingup').modal('show');
        },
        sendSignup() {
            this.fullscreenLoading = true;
            const url = '/api/auth/signup';

            axios.post(url, this.signupForm)
            .then(res => {
                $('#modalSignup').modal('hide');
                this.fullscreenLoading = false;
            })
            .catch(err => {
                this.fullscreenLoading = false;
                this.errors = err.response.data.errors;
            });
        },
        logout() {
            this.fullscreenLoading = true;
            const url = '/api/auth/logout';

            axios.get(url)
            .then(res => {
                localStorage.removeItem('access_token');
                localStorage.removeItem('authUser');
                EventBus.$emit('verifyAuthenticatedUser');
                this.fullscreenLoading = false;
            })
            .catch(err => {
                EventBus.$emit('verifyAuthenticatedUser');
                this.fullscreenLoading = false;
            });
        }
    }
}
</script>

<style>

</style>
