<template>
    <div class="card">
        <!-- Carga de datos -->
        <div v-if="!loaded" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>

        <div class="card-header">
            <h1 class="card-title">Ordenes</h1>
        </div>

        <div class="card-body" v-loading.fullscreen.lock="fullscreenLoading">
            <div class="container-fluid">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Criterio de Busqueda</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-sm-6 col-md-4 col-lg-3">
                                <label class="control-label">Nombre</label>
                                <input v-model="searches.name" type="text" class="form-control" name="name" placeholder="Nombre">
                            </div>
                            <div class="form-group col-sm-6 col-md-4 col-lg-3">
                                <label class="control-label">Cliente</label>
                                <input v-model="searches.client" type="text" class="form-control" name="client" placeholder="Cliente">
                            </div>
                            <div class="form-group col-sm-6 col-md-4 col-lg-3">
                                <label class="control-label">Pizza</label>
                                <input v-model="searches.pizza" type="text" class="form-control" name="pizza" placeholder="Pizza">
                            </div>
                            <div class="form-group col-auto mt-4 pt-2">
                                <button @click="clearSearches()" title="Eliminar Filtros" type="button"
                                    class="btn waves-effect waves-light btn-danger float-right">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Bandeja de Resultados
                            <span v-show="orders.length" class="right badge badge-dark">{{ orders.length }}</span>
                        </h3>
                    </div>

                    <div v-if="orders.length" class="card-body">
                        <div class="card-body table-responsive">
                            <table class="table table-hover table-head-fixed text-nowrap projects">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Hora Entrega</th>
                                        <th>Pizza</th>
                                        <th>Creada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(order, index) in orders" :key="index">
                                        <td v-text="order.id"></td>
                                        <td v-text="order.user.email"></td>
                                        <td v-text="order.delivery_time"></td>
                                        <td>{{order.pizzas.map(p => p.name).join(', ')}}</td>
                                        <td>{{order.updated_at | formatDate}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                        No hay ningún elemento para mostrar
                    </div>
                </div>

            </div>

        </div>

    </div>
</template>

<script>
import moment from 'moment';

export default {

    created() {
        this.getOrders();
    },
    watch: {
        'searches.name': function (newValue, oldValue) {
            this.getOrders();
        },
        'searches.client': function (newValue, oldValue) {
            this.getOrders();
        },
        'searches.pizza': function (newValue, oldValue) {
            this.getOrders();
        },
    },
    data() {
        return {
            orders: [],
            searches: {
                name: '',
                client: '',
                pizza: ''
            },

            fullscreenLoading: false,
            loaded: false
        }
    },
    methods: {
        getOrders() {
            this.loaded = false;
            const url = `/api/orders`;

            axios.get(url, {
                params: this.searches
            }).then(res => {
                this.orders = res.data;
                this.loaded = true;
            }).catch(err => {
                EventBus.$emit('verifyAuthenticatedUser');
                this.loaded = true;
            });
        },
        clearSearches() {
            this.searches = {
                name: '',
                client: '',
                pizza: ''
            };
        }
    },
    filters: {
        formatDate(value) {
            return moment(value ).format('DD/MM/YYYY HH:mm:ss');
        }
    }

}
</script>
