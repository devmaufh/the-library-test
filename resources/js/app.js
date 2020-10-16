import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader
require('./bootstrap');
window.Vue = require('vue');

import App from './App.vue'
import Vuetify from 'vuetify'
import router from './router'
import store from './stores'


Vue.use(Vuetify)

const app = new Vue({
    el: '#app',
    router,
    store,
    render : h => h(App),
    vuetify : new Vuetify({
        icons : {
            iconfont: 'mdi', // default - only for display purposes
        }
    }),

});
