<template>
    <div class="modal fade" id="modalPizzaFormAddEdit" tabindex="-1" role="dialog" aria-hidden="true" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 v-if="modalType=='add'" class="modal-title">Nueva Pizza</h4>
                    <h4 v-else class="modal-title">Editar Pizza</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="needs-validation" v-on:submit.prevent="actionStoreUpdate">
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name" :class="['control-label', errors.name ? 'text-danger' : '']">Nombre</label>
                                <input v-model="form.name" type="text" :class="['form-control', errors.name ? 'is-invalid' : '']" name="name" placeholder="Nombre" required>
                                <small v-if="errors.name" class="form-control-feedback text-danger">
                                    {{ errors.name[0] }}
                                </small>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="price" :class="['control-label', errors.price ? 'text-danger' : '']">Precio</label>
                                <input v-model="form.price" type="text" :class="['form-control', errors.price ? 'is-invalid' : '']" name="price" placeholder="Precio">
                                <small v-if="errors.price" class="form-control-feedback text-danger">
                                    {{ errors.price[0] }}
                                </small>
                            </div>
                            <div class="form-group col-12">
                                <label for="description" :class="['control-label', errors.description ? 'text-danger' : '']">Descripción</label>
                                <textarea v-model="form.description" :class="['form-control', errors.description ? 'is-invalid' : '']" name="description"></textarea>
                                <small v-if="errors.description" class="form-control-feedback text-danger">
                                    {{ errors.description[0] }}
                                </small>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="Ingredients" :class="['control-label', errors.ingredients ? 'text-danger' : '']">Ingredientes</label>
                                <!-- <input type="text" :class="['form-control', errors.roles ? 'is-invalid' : '']" name="roles" placeholder="Roles"> -->
                                <multiselect
                                    v-model="form.ingredients"
                                    :options="allIngredients"
                                    placeholder="Ingredientes"
                                    label="name"
                                    track-by="id"
                                    :multiple="true"
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    :preserve-search="true"
                                    >
                                </multiselect>
                                <small v-if="errors.ingredients" class="form-control-feedback text-danger">
                                    {{ errors.ingredients[0] }}
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
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';

export default {
    components: {Multiselect},
    mounted() {
        this.getAllIngredients();
    },
    data() {
        return {
            modalType: 'add', //add, edit
            allIngredients: [],
            form: {
                name: '',
                price: '',
                description: '',
                ingredients: [],
                id: ''
            },
            errors: {},

            fullscreenLoading: false
        }
    },
    methods: {
        showForm(action, pizza = null) {
            if(this.modalType != action) {
                this.clearForm();
            }
            this.modalType = action;
            if(this.modalType === 'edit' && pizza) {
                this.form = {
                    name: pizza.name,
                    price: pizza.price,
                    description: pizza.description,
                    ingredients: pizza.ingredients,
                    id: pizza.id
                }
            }
            this.erros = {};
            $('#modalPizzaFormAddEdit').modal('show');
        },
        actionStoreUpdate() {
            this.fullscreenLoading = true;
            switch (this.modalType) {
                case 'add':
                    this.storePizza();
                    break;

                case 'edit':
                    this.updatePizza();
                    break;
            }
        },
        storePizza() {
            let formData = new FormData;
            for (const property in this.form) {
                if(property !== 'id') {
                    if(property === 'ingredients'){
                        let arr_ids = this.form[property].map(item => item.id);
                        for (let i = 0; i < arr_ids.length; i++) {
                            formData.append(property+'[]', arr_ids[i]);
                        }
                    }else{
                        formData.append(property, this.form[property]);
                    }
                }
            }

            const url = '/api/pizzas/store';
            axios.post(url, formData)
            .then(res => {
                this.fullscreenLoading = false;
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.$emit('updatePizzaList', 'add');
                $('#modalPizzaFormAddEdit').modal('hide');
                this.clearForm();
            })
            .catch(err => {
                this.fullscreenLoading = false;
                if(err.response && err.response.status == 422) {
                    this.errors = err.response.data.errors;
                    this.errorsIngredients();
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
        },
        updatePizza() {
            /* let formData = new FormData;
            for (const property in this.form) {
                if(property !== 'id') {
                    if(property === 'ingredients'){
                        let arr_ids = this.form[property].map(item => item.id);
                        for (let i = 0; i < arr_ids.length; i++) {
                            formData.append(property+'[]', arr_ids[i]);
                        }
                    }else{
                        formData.append(property, this.form[property]);
                    }
                }
            }
            formData.append("_method", "put"); */

            const url = `/api/pizzas/${this.form.id}/update`;
            axios.put(url, {
                    name: this.form.name,
                    price: this.form.price,
                    description: this.form.description,
                    ingredients: this.form.ingredients.map(item => item.id)
            }).then(res => {
                this.fullscreenLoading = false;
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.$emit('updatePizzaList', 'edit');
                $('#modalPizzaFormAddEdit').modal('hide');
                this.clearForm();
            })
            .catch(err => {
                this.fullscreenLoading = false;
                if(err.response && err.response.status == 422) {
                    this.errors = err.response.data.errors;
                    this.errorsIngredients();
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
        },
        clearForm() {
            this.form = {
                name: '',
                price: '',
                description: '',
                Ingredients: [],
                id: ''
            };
            this.errors = {};
        },
        getAllIngredients() {
            const url = '/api/ingredients';
            axios.get(url)
            .then(res => {
                this.allIngredients = res.data;
            })
            .catch(err => {
                console.error(err);
            })
        },
        errorsIngredients() {
            //Buscar los errores de los elementos del array permissions
            if(Object.keys(this.errors).length !== 0) {
                if(!this.errors.ingredients){
                    for (let i = 0; i < this.allIngredients.length; i++) {
                        if(this.errors.hasOwnProperty(`ingredients.${i}`)){
                            this.errors.ingredients = this.errors[`ingredients.${i}`];
                            break;
                        }
                    }
                }
            }
        }
    },
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

