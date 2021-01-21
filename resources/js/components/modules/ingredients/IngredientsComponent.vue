<template>
    <div class="card">
        <!-- Carga de datos -->
        <div v-if="!loaded" class="overlay"><i class="fas fa-2x fa-sync-alt fa-spin"></i></div>

        <div class="card-header">
            <h1 class="card-title">Ingrediente</h1>
            <div class="card-tools">
                <button @click="openModalAddEdit('add')" class="btn btn-info btn-sm">
                    <i class="fas fa-plus-square"> Nuevo Ingrediente</i>
                </button>
            </div>
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
                            <span v-show="ingredients.length" class="right badge badge-dark">{{ ingredients.length }}</span>
                        </h3>
                    </div>

                    <div v-if="ingredients.length" class="card-body">
                        <div class="card-body table-responsive">
                            <table class="table table-hover table-head-fixed text-nowrap projects">
                                <thead>
                                    <tr>
                                        <th>nombre</th>
                                        <th>Price</th>
                                        <th>description</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(ingredient, index) in ingredients" :key="index">
                                        <td v-text="ingredient.name"></td>
                                        <td v-text="ingredient.price"></td>
                                        <td v-text="ingredient.description"></td>
                                        <td>
                                            <button v-if="false" @click="openModalAddEdit('edit', ingredient)"
                                                class="btn btn-flat btn-success btn-xs" title="Editar">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button @click="openModalAddEdit('edit', ingredient)"
                                                class="btn btn-flat btn-info btn-xs" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <button @click="destroyIngredient(ingredient)"
                                                class="btn btn-flat btn-danger btn-xs" title="Desactivar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div v-else class="alert alert-warning mx-2 text-center" style="margin-top: 18px;">
                        No hay ningún elemento para mostrar
                    </div>
                </div>

                <ingredient-form-add-edit ref="ingredientFormAddEdit" @updateIngredientList="updateIngredientList"></ingredient-form-add-edit>

            </div>

        </div>

    </div>
</template>

<script>
import IngredientFormAddEdit from './IngredientFormAddEditComponent';

export default {
    components: {IngredientFormAddEdit},
    created() {
        this.getIngredients();
    },
    watch: {
        'searches.name': function (newValue, oldValue) {
            this.getIngredients();
        },
    },
    data() {
        return {
            ingredients: [],
            searches: {
                name: ''
            },

            fullscreenLoading: false,
            loaded: false
        }
    },
    methods: {
        getIngredients() {
            this.loaded = false;
            const url = `/api/ingredients`;

            axios.get(url, {
                params: this.searches
            }).then(res => {
                this.ingredients = res.data;
                this.loaded = true;
            }).catch(err => {
                EventBus.$emit('verifyAuthenticatedUser');
                this.loaded = true;
            });
        },
        openModalAddEdit(action, ingredient = null) {
            this.$refs.ingredientFormAddEdit.showForm(action, ingredient);
        },
        clearSearches() {
            this.searches = {
                name: ''
            };
        },
        updateIngredientList() {
            this.getIngredients();
        },
        destroyIngredient(ingredient) {
            this.loaded = false;
            const url = `/api/ingredients/${ingredient.id}/destroy`;

            axios.delete(url).then(res => {
                    this.loaded = true;
                    Swal.fire({
                        title: res.data.message,
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    this.getIngredients();
                }).catch(err => {
                    if(err.response.data.msg_error || err.response.data.message) {
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
