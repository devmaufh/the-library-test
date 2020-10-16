export default {
    namespaced: true,
    state: {
        obras: {
            items: [],
            headers: [{
                text: "Folio",
                align: "start",
                value: "folio",
                },
                {
                    text: "Obra",
                    value: "obra",
                },
                {
                    text: "Calle",
                    value: "calle",
                },
                {
                    text: "Colonia",
                    value: "colonia",
                },
                {
                    text: "Fecha Alta",
                    value: "fecha",
                },
                {
                    text: "Detalles",
                    value: "detalles",
                },

            ]
        }
    },
    getters: {},
    actions: {
        insertObra({ commit, dispatch }, payload) {
            commit('pushObraIntoArray', payload)
        },
        updateObra({ commit, dispatch }, payload) {
            commit('updateObraInArray', payload)
        }
    },
    mutations: {
        pushObraIntoArray(state, obra) {
            state.obras.items.push(obra);
        },
        updateObraInArray({state, obra}) {
            const itemIndex = state.obras.items.findIndex( item => item.folio === obra.folio )
            if(itemIndex !== -1) state.obras.items.splice(index, 1, obra)
        }
    },
}
