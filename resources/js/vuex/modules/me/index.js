import axios from "axios"
const CONFIGS = {
    headers: {
        'content-type': 'multipart/form-data'
    }
}

export default {
    state: {
        favorites: [],
        me: {
            name: "",
            email: "",
            photo: "",
            isMyFavorite: false,
            preference: {
                me_notify: true,
                background_chat: ""
            }
        }
    },

    mutations: {

        SET_ME (state, me) {
            state.me = me
        }
    },

    actions: {

        getMe ({commit}) {
            axios.get('/api/v1/me')
                    .then(response => commit('SET_ME', response.data.data))
        },

        updatePhotoProfile ({dispatch}, formData) {
            formData.append('_method', 'PATCH')
            return axios.post('/api/v1/profile/update-photo', formData, CONFIGS)
                            .then(response => dispatch('getMe'))
        },

        update ({ dispatch }, formData) {
            return axios.patch('/api/v1/profile/update', {...formData})
                        .then(response => dispatch('getMe'))
        },

        toogleNotify ({ dispatch, state }) {
            return axios.patch('/api/v1/profile/update-preference', {
                me_notify: state.me.preference.me_notify
            })
        },

        updateImageChat ({dispatch}, formData) {
            formData.append('_method', 'PATCH')
            return axios.post('/api/v1/profile/update-image-chat', formData, CONFIGS)
                            .then(response => dispatch('getMe'))
        },

        removeImageChat ({dispatch}) {
            return axios.patch('/api/v1/profile/remove-image-chat')
                            .then(response => dispatch('getMe'))
        },

        logout () {
            return axios.post('/api/v1/logout')
        }
    }
}
