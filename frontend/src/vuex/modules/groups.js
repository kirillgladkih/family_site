import axios from "axios"
import _ from 'lodash'

let url = `http://${location.hostname}/api/groups`;

const state = {
    groups: []
}
const getters = {
    GROUPS(state) {
        return state.groups;
    }
}

const actions = {
    GET_GROUPS_API({
        commit
    }) {
        return axios.get(url)
            .then(response => {
                commit('SET_GROUPS_STATE', response.data)

                return response.data;
            })
            .catch(response => {
                throw response
            })
    },
    GET_DATEIL_GROUPS({
        commit
    }, id) {
       return axios.get(`${url}/${id}`)
            .then(response => {
                return response.data;
            })
            .catch(response => {
                throw response
            })
    },
    DELETE_GROUPS_API({
        commit
    }, id) {
        return axios.delete(`${url}/${id}`)
            .then(response => {
                commit('DELETE_GROUPS_STATE', id)
                return response.data;
            })
            .catch(response => {
                throw response
            })
    },

    SAVE_GROUPS_API({
        commit
    }, data) {
        return axios.post(url, data)
            .then(response => {
                commit('PUSH_GROUPS_STATE', response.data)

                return response.data;
            })
            .catch(response => {
                let tmp = response.response.data.errors
                let errors = []
                _.forEach(tmp, function (value) {
                    errors.push(value[0])
                });
                throw errors
            })
    },

    UPDATE_GROUPS_API({
        commit
    }, data) {
        return axios.put(`${url}/${data.id}`, data)
            .then(response => {
                commit('UPDATE_GROUPS_STATE', response.data)

                return response.data;
            })
            .catch(response => {
                let tmp = response.response.data.errors
                let errors = []

                _.forEach(tmp, function (value) {
                    errors.push(value[0])
                });

                throw errors
            })
    },

}

const mutations = {
    SET_GROUPS_STATE: (state, data) => {
        state.groups = data
    },
    PUSH_GROUPS_STATE: (state, data) => {
        state.groups.push(data)
    },
    DELETE_GROUPS_STATE: (state, id) => {
        state.groups = state.groups.filter(item => item.id !== id)
    },
    UPDATE_GROUPS_STATE: (state, data) => {
        state.groups = state.groups.map(
            item => item.id === data.id ?
            data : item
        )
    },
}


export default {
    state,
    getters,
    mutations,
    actions
}
