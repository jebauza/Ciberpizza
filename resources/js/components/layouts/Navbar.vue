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
                    <a href="#" class="dropdown-item" hidden="hidden"><i class="fas fa-address-card"></i> Perfil</a>
                    <a href="https://quepar.local/configuration" class="dropdown-item"><i class="fas fa-cog"></i> Configuración</a>
                    <a href="https://quepar.local/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </a>
                </div>
            </li>

            <!-- Sin Login -->
            <!-- <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Registrarse</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">login</a>
            </li> -->

        </ul>
    </nav>

</template>

<script>
export default {
    props: ['basepath'],
    mounted() {

    },
    data() {
        return {
            d: 'dd'
        }
    },
    methods: {

    }
}
</script>

<style>

</style>
