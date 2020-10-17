import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import Category from './views/Category.vue'
import Book from './views/Book.vue'
Vue.use(Router)

export default new Router({
    mode: 'history',
    base: process.env.APP_URL,
    routes: [
        {
            path: '/category',
            name : 'category',
            component: Category
        },{
            path : '/book',
            name : 'book',
            component : Book
        }
    ]
})
