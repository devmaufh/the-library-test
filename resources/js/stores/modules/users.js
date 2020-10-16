export default {
    namespaced: true,
    state:  {
        users: {
            list : [],
            page : 1,
            pageCount : 0,
            filter : '',
        },
    },
    getters: {
        getUserById: state => id => {
            return state.users.find(user => user.id === id)
        }
    },
    actions: {
        fetchUsers({ commit }, page) {
            return axios.get(`usuarios?page=${page}`).then(response => {
                commit('setUsers', response.data)
            })
        },
        async insertUser({ commit, dispatch }, payload) {
            // console.log(payload)
            await axios.post('usuarios',payload).then(response=> {
                console.log(response)
            }).catch(error => { console.warn(error) })
        }
    },
    mutations: {
        setUsers(state, users) {
            state.users.list       = users.data
            state.users.page       = users.current_page
            state.users.pageCount  = users.last_page
        },
    },
}
