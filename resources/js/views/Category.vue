<template>
<v-container>
    <v-data-table :items-per-page="10" :server-items-length="category.total" :options.sync="options" :loading="loading" loading-text="Cargando información..." :headers="headers" :items="category.list" item-key="id" class="elevation-1">
        <template v-slot:top>
            <v-toolbar flat color="white">
                <v-toolbar-title>Categories</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-spacer></v-spacer>
                <v-dialog v-model="dialog" persistent max-width="500px">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">New category</v-btn>
                    </template>
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ formTitle }}</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <ValidationObserver ref="observer" v-slot="{ validate, reset }">
                                    <v-form>
                                        <v-row>
                                            <v-col cols="12" sm="12" md="12">
                                                <ValidationProvider v-slot="{ errors }" name="Name" rules="required|max:150">
                                                    <v-text-field v-model="editedItem.name" label="Name *" :error-messages="errors" :counter="150"></v-text-field>
                                                </ValidationProvider>
                                            </v-col>
                                            <v-col cols="12" sm="12" md="12">
                                                <ValidationProvider v-slot="{ errors }" name="Description" rules="max:300">
                                                    <v-text-field v-model="editedItem.description" label="Description *" :error-messages="errors"></v-text-field>
                                                </ValidationProvider>

                                            </v-col>
                                        </v-row>
                                    </v-form>
                                </ValidationObserver>

                                <small class="text-warning">*Campos requeridos</small>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="secondary" text @click="close()">Cancel</v-btn>
                            <v-btn color="primary" text @click="save()">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-toolbar>
        </template>
        <template v-slot:item.actions="{ item }">
            <v-icon small class="mr-2" @click="editCategory(item)">
                mdi-pencil
            </v-icon>
            <v-icon small @click="deleteCategory(item)">
                mdi-delete
            </v-icon>
        </template>

    </v-data-table>

    <v-dialog v-model="loadingModal.loading" hide-overlay persistent width="300">
        <v-card :color="loadingModal.color" dark>
            <v-card-text>
                {{ loadingModal.text }}
                <v-progress-linear indeterminate color="white" class="mb-0"></v-progress-linear>
            </v-card-text>
        </v-card>
    </v-dialog>

    <v-snackbar v-model="snack" :timeout="3000" :color="snackColor">
        {{ snackText }}
        <template v-slot:action="{ attrs }">
            <v-btn v-bind="attrs" text @click="snack = false">Cerrar</v-btn>
        </template>
    </v-snackbar>
</v-container>
</template>

<script>
import {
    required,
    max
} from 'vee-validate/dist/rules'

import {
    extend,
    setInteractionMode,
    ValidationObserver,
    ValidationProvider
} from 'vee-validate'
import CategoryService from '../services/CategoryService'
import axios from 'axios'
const apiCategoryService = new CategoryService(axios)

setInteractionMode('eager')
extend('required', {
    ...required,
    message: 'El campo {_field_} no puede estar vacio'
})
extend('max', {
    ...max,
    'message': '{_field_} no puede exceder los {length} caracteres'
})

export default {
    components: {
        ValidationProvider,
        ValidationObserver,
    },
    data() {
        return {
            category: {},
            headers: [{
                    text: `Category`,
                    value: `name`,
                    sortable: false
                },
                {
                    text: `Description`,
                    value: `description`,
                    sortable: false
                },
                {
                    text: `Actions`,
                    value: `actions`,
                    sortable: false
                }
            ],
            dialog: false,
            editedIndex: -1,
            editedItem: {
                name: ''
            },
            defaultItem: {
                name: ''
            },
            snack: false,
            snackColor: '',
            snackText: '',
            loadingModal: {
                loading: false,
                color: 'primary',
                text: 'Eliminando registro'
            },
            loading: true,
            options: {
                page: 1,
                itemsPerPage: 10
            },
            showModal: false,
        }
    },
    watch: {
        options: {
            handler() {
                this.loading = true
                this.fetchCategories(this.options)
            }
        },
    },
    methods: {
        async deleteCategory(category) {
            this.loadingModal.color = 'red'
            this.loadingModal.text = 'Deleting category'
            this.loadingModal.loading = true
            this.loading = false
            await apiCategoryService.delete(category.id)
            this.loadingModal.loading = false
            this.loading = true
            this.fetchCategories(this.options)
            this.close()

        },
        editCategory(category) {
            this.editedIndex = this.category.list.indexOf(category)
            this.editedItem = Object.assign({}, category)
            this.dialog = true
        },
        close() {
            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
            this.$refs.observer.reset()

        },
        async save() {
            let isValid = await this.$refs.observer.validate()
            if (!isValid) return
            this.loading = true
            if (this.editedIndex === -1) { //Save category
                await apiCategoryService.post(this.editedItem)
            } else { //Edit category
                await apiCategoryService.edit(this.editedItem, this.editedItem.id)
            }
            this.fetchCategories(this.options)
            this.close()
        },
        async fetchCategories(options) {
            let response = await apiCategoryService.getAll(options)
            this.loading = false
            this.category.list = response.data.data
            this.category.page = response.data.current_page
            this.category.pageCount = response.data.last_page
            this.category.total = response.data.total
        }
    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New' : 'Edit'
        },
    },
    created() {

    }
}
</script>

<style>

</style>
