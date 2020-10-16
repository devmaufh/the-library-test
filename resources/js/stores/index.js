import Vue  from 'vue'
import Vuex from 'vuex'
import version from '../../../package.json'
import users from './modules/users'
import obras from './modules/obras'
Vue.use(Vuex)


export default new Vuex.Store({
    strict: true, //process.env.NODE_ENV !== 'production',
    state : {
        version : '',
    },
    mutations : {
        initialStoreState(state) {
            if(localStorage.getItem('store')){
                let store = JSON.parse(localStorage.getItem('store'))
                this.replaceState(
                    Object.assign(state, store)
                );
                // if(store.version == version){
                // }else{
                //     state.version = version;
                // }
            }
        }
    },
    modules : {
        obras,
        users,
    }
})

