<template>
<v-container>
    <v-data-table dense :loading="loading" :headers="headers" :items="books.list" :items-per-page="10" :server-items-length="books.total" :options.sync="options" item-key="id" class="elevation-0">
        <template #item.is_borrowed="{ item }">
            <v-chip class="ma-2" color="amber" text-color="white" v-if="item.is_borrowed === true">
                Borrowed to {{ item.user }}
            </v-chip>
            <v-chip class="ma-2" color="success" text-color="white" v-else>
                Available
            </v-chip>
        </template>
        <template #item.created_at="{item}">
            {{ item.created_at.substring(0,10) }}
        </template>
        <template v-slot:top>
            <v-container>
                <v-row>
                    <v-col>
                        <v-toolbar flat>
                            <v-toolbar-title>Books list</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-dialog v-model="dialog" persistent max-width="500px">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">New book</v-btn>
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
                                                            <ValidationProvider v-slot="{ errors }" name="Author" rules="required|max:150">
                                                                <v-text-field v-model="editedItem.author" label="Author *" :error-messages="errors"></v-text-field>
                                                            </ValidationProvider>
                                                        </v-col>
                                                        <v-col cols="12" sm="12" md="12">

                                                            <v-menu v-model="datePicker" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="290px">
                                                                <template v-slot:activator="{ on, attrs }">
                                                                    <ValidationProvider v-slot="{ errors }" name="Published date" rules="required">
                                                                        <v-text-field v-model="editedItem.published_date" label="Published date" readonly v-bind="attrs" v-on="on" :error-messages="errors"></v-text-field>
                                                                    </ValidationProvider>
                                                                </template>
                                                                <v-date-picker v-model="editedItem.published_date" @input="datePicker = false"></v-date-picker>
                                                            </v-menu>
                                                        </v-col>
                                                        <v-col cols="12" sm="12" md="6">
                                                            <v-switch v-show="!showSwitch" v-model="editedItem.is_borrowed" @change="checkAvailability">
                                                                <template v-slot:label>
                                                                    {{ editedItem.is_borrowed ? 'Set book as available' : 'Lend borrow' }}
                                                                </template>
                                                            </v-switch>
                                                        </v-col>
                                                        <v-col cols="12" sm="12" md="6" v-show="editedItem.is_borrowed">
                                                            <ValidationProvider v-slot="{ errors }" name="User" rules="max:150">
                                                                <v-text-field v-model="editedItem.user" label="User *" :error-messages="errors"></v-text-field>
                                                            </ValidationProvider>
                                                        </v-col>

                                                        <v-col cols="12" sm="12" md="12">
                                                            <ValidationProvider v-slot="{ errors }" name="Category" rules="required">
                                                                <v-autocomplete v-model="editedItem.category_id" item-value="id" :items="categories" label="Category" item-text="name" :error-messages="errors"></v-autocomplete>
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
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" sm="12" md="6">
                        <v-spacer></v-spacer>
                    </v-col>
                    <v-col cols="12" sm="8" md="4">
                        <v-text-field dense v-model="searchModel" prepend-inner-icon="mdi-magnify" clear-icon="mdi-close-circle" clearable label="Search" type="text" @click:clear="fetchBooks({page: 1,itemsPerPage: 10}, null)" hint="Ex. Harry Potter"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="4" md="2">
                        <v-btn class="ma-2" depressed block @click="fetchBooks({page: 1,itemsPerPage: 10}, searchModel)">
                            Search
                        </v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </template>
        <template v-slot:item.actions="{ item }">
            <v-btn x-small text color="primary" @click="editBook(item)">
                <v-icon x-small class="mr-2">
                    mdi-pencil
                </v-icon>Edit
            </v-btn>
            <v-btn x-small text color="error">
                <v-icon x-small @click="deleteBook(item)">
                    mdi-delete
                </v-icon>Error
            </v-btn>

        </template>
    </v-data-table>
</v-container>
</template>

<script>
import CategoryService from '../services/CategoryService'
import BookService from '../services/BookService'
import axios from 'axios'
const ApiBookService = new BookService(axios)
const ApiCategoryService = new CategoryService(axios)

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
    data: () => ({
        books: {},
        categories: [],
        headers: [{
            text: `Name`,
            value: `name`,
            sortable: false
        }, {
            text: `Author`,
            value: `author`,
            sortable: false
        }, {
            text: `Published date`,
            value: `published_date`,
            sortable: false
        }, {
            text: `category`,
            value: `category`,
            sortable: false
        }, {
            text: `Status`,
            value: `is_borrowed`,
            sortable: false
        }, {
            text: `Actions`,
            value: `actions`,
            sortable: false
        }],
        options: {
            page: 1,
            itemsPerPage: 10
        },
        loading: false,
        searchModel: null,
        dialog: false,
        datePicker: false,
        editedIndex: -1,
        editedItem: {
            user: null,
            is_borrowed: false,
            published_date: new Date().toISOString().substr(0, 10),
        },
        defaultItem: {
            user: null,
            is_borrowed: false,
            published_date: new Date().toISOString().substr(0, 10),
        },
        showTextFields: true,
    }),
    watch: {
        dialog: function (value) {
            if (value) this.showTextFields = true
        },
        searchModel: function (val) {
            if (val === '') this.searchModel = null
        },
        options: {
            handler() {
                this.loading = true
                this.fetchBooks(this.options, this.searchModel)
            }
        },
    },

    methods: {
        async fetchCategories() {
            let categoriesData = await ApiCategoryService.getAll({
                page: 1,
                itemsPerPage: -1
            })
            this.categories = categoriesData.data.data
        },
        async fetchBooks(payload, filter) {
            this.loading = true
            let booksData = await ApiBookService.getAll(payload, filter)
            this.books.list = booksData.data.data
            this.books.page = booksData.data.current_page
            this.books.pageCount = booksData.data.last_page
            this.books.total = booksData.data.total
            this.loading = false
        },

        async save() {
            let isValid = await this.$refs.observer.validate()
            if (!isValid) return
            this.loading = true
            if (this.editedIndex === -1) { //Save book
                console.log('save Book')
                ApiBookService.post(this.editedItem)
            } else { //Edit book
                ApiBookService.update(this.editedItem, this.editedItem.id)
            }
            this.fetchBooks(this.options, null)
            this.close()
        },
        async editBook(book) {
            console.log('edit book', book)
            this.editedIndex = this.books.list.indexOf(book)
            this.editedItem = Object.assign({}, book)
            this.dialog = true
        },
        async deleteBook(book) {
            console.log('delete book', book)
        },
        close() {
            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
            this.$refs.observer.reset()
        },
        checkAvailability() {
            if (this.editedItem.is_borrowed === false) this.editedItem.user = null
        },

    },
    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'New' : 'Edit'
        },
        showSwitch() {
            return this.formTitle === 'New';
        }
    },
    created() {
        this.fetchBooks(this.options, '')
        this.fetchCategories()
    }
}
</script>
