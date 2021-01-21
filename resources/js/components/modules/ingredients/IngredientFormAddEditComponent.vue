<template>
    <div class="modal fade" id="modalIngredientFormAddEdit" tabindex="-1" role="dialog" aria-hidden="true" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 v-if="modalType=='add'" class="modal-title">Nuevo Ingrediente</h4>
                    <h4 v-else class="modal-title">Editar Ingrediente</h4>
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

export default {
    data() {
        return {
            modalType: 'add', //add, edit
            form: {
                name: '',
                price: '',
                description: '',
                id: ''
            },
            errors: {},

            fullscreenLoading: false
        }
    },
    methods: {
        showForm(action, ingredient = null) {
            if(this.modalType != action) {
                this.clearForm();
            }
            this.modalType = action;
            if(this.modalType === 'edit' && ingredient) {
                this.form = {
                    name: ingredient.name,
                    price: ingredient.price,
                    description: ingredient.description,
                    id: ingredient.id
                }
            }
            this.erros = {};
            $('#modalIngredientFormAddEdit').modal('show');
        },
        actionStoreUpdate() {
            this.fullscreenLoading = true;
            switch (this.modalType) {
                case 'add':
                    this.storeIngredient();
                    break;

                case 'edit':
                    this.updateIngredient();
                    break;
            }
        },
        storeIngredient() {
            const url = '/api/ingredients/store';

            axios.post(url, this.form)
            .then(res => {
                this.fullscreenLoading = false;
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.$emit('updateIngredientList', 'add');
                $('#modalIngredientFormAddEdit').modal('hide');
                this.clearForm();
            })
            .catch(err => {
                this.fullscreenLoading = false;
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
        },
        updateIngredient() {
            const url = `/api/ingredients/${this.form.id}/update`;

            axios.put(url, this.form).then(res => {
                this.fullscreenLoading = false;
                Swal.fire({
                    title: res.data.message,
                    icon: "success",
                    timer: 1500,
                    showConfirmButton: false
                });
                this.$emit('updateIngredientList', 'add');
                $('#modalIngredientFormAddEdit').modal('hide');
                this.clearForm();
            })
            .catch(err => {
                this.fullscreenLoading = false;
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
        },
        clearForm() {
            this.form = {
                name: '',
                price: '',
                description: '',
                id: ''
            };
            this.errors = {};
        },
    },
}
</script>


