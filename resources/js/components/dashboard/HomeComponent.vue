<template>
    <div >

        <div class="card">

            <!-- Carga de datos -->
            <div v-if="!loaded" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>

            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>Pizza</th>
                            <th>Precio</th>
                            <th>Descripción</th>
                            <th>Ingredientes</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(pizza, index) in pizzas" :key="index">
                            <td v-text="pizza.name"></td>
                            <td v-text="pizza.price"></td>
                            <td v-text="pizza.description"></td>
                            <td>{{ pizza.ingredients.map((i) => i.name).join(', ') }}</td>
                            <td>
                                <button type="button" class="btn btn-success btn-sm" @click="showTime(pizza)" :disabled="!isAuth">Comprar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Singup -->
        <div class="modal fade" id="modalTime" tabindex="-1" role="dialog" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Selecione hora</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form class="needs-validation" v-on:submit.prevent="storeOrder">
                        <div class="modal-body">

                            <div class="form-row">

                                <div class="form-group col-12">
                                    <label for="time" :class="['control-label', errors.time ? 'text-danger' : '']">Hora</label>
                                    <date-picker v-model="form.time" :config="pickerOptions"></date-picker>
                                    <small v-if="errors.time" class="form-control-feedback text-danger">
                                        {{ errors.time[0] }}
                                    </small>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" v-loading.fullscreen.lock="fullscreenLoading" >Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.css';
import datePicker from 'vue-bootstrap-datetimepicker';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
import moment from 'moment'


export default {
    components: {datePicker},
    created() {
        this.getPizzas();

        EventBus.$on('updateAuthenticatedUser', () => {
            this.isAuth = JSON.parse(localStorage.getItem('authUser')) ? true : false;
        });
    },
    data() {
        return {
            pizzas: [],
            isAuth: JSON.parse(localStorage.getItem('authUser')) ? true : false,
            form: {
                time: '22:30',
                pizzaId: ''
            },
            pickerOptions: {
                format: 'DD/MM/YYYY HH:mm:ss',
                showClear: true,
                showClose: true,
            },
            errors: {},
            loaded: false,
            fullscreenLoading: false
        }
    },
    methods: {
        getPizzas() {
            this.loaded = false;
            const url = `/api/pizzas`;

            axios.get(url).then(res => {
                this.pizzas = res.data;
                this.loaded = true;
            }).catch(err => {
                this.loaded = true;
            });
        },
        buyPizza(pizza) {

        },
        showTime(pizza) {
            this.errors = {};
            this.form = {
                time: '',
                pizza: pizza
            };
            $('#modalTime').modal('show');
        },
        storeOrder() {
            console.log(this.form);
            this.loaded = false;
            const url = `/api/orders/store`;

            axios.post(url,{
                delivery_time: moment(this.form.time, 'DD/MM/YYYY HH:mm:ss').format('YYYY-MM-DD HH:mm:ss'),
                price: this.form.pizza.price,
                pizzas: [this.form.pizza.id]
            }).then(res => {
                this.loaded = true;
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#modalTime').modal('hide');
            }).catch(err => {
                this.loaded = true;
                if(err.response && err.response.status == 422) {
                    this.errors = err.response.data.errors;
                }else if(err.response.data.msg_error || err.response.data.message) {
                    Swal.fire({
                        title: 'Error!',
                        text: err.response.data.msg_error ?? err.response.data.message,
                        icon: "error",
                        showCloseButton: true,
                        closeButtonColor: 'red',
                    });
                }
            });
        }
    },
}
</script>
