import axios from "axios"
import _ from 'lodash'

let url = `http://${location.hostname}/api/clients`;

const state = {
    clients: []
}
const getters = {
    CLIENTS: state => state.clients.filter(item => item.status_id == 2),
    LEEDS: state => state.clients.filter(item => item.status_id == 1),
    FOR_RECORD: state => state.clients.filter(item => item.type_id != 2),
}

const actions = {
    GET_CLIENTS_API({
        commit
    }) {
        return axios.get(url)
            .then(response => {
                commit('SET_CLIENTS_STATE', response.data)

                return response.data;
            })
            .catch(response => {
                throw response
            })
    },
    GET_DATEIL_CLIENTS({
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
    DELETE_CLIENTS_API({
        commit
    }, id) {
        return axios.delete(`${url}/${id}`)
            .then(response => {
                commit('DELETE_CLIENTS_STATE', id)
                return response.data;
            })
            .catch(response => {
                throw response
            })
    },

    SAVE_CLIENTS_API({
        commit
    }, data) {
        return axios.post(url, data)
            .then(response => {
                commit('PUSH_CLIENTS_STATE', response.data)

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

    UPDATE_CLIENTS_API({
        commit
    }, data) {
        return axios.put(`${url}/${data.id}`, data)
            .then(response => {
                commit('UPDATE_CLIENTS_STATE', response.data)

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
    SET_CLIENTS_STATE: (state, data) => {
        state.clients = data
    },
    PUSH_CLIENTS_STATE: (state, data) => {
        state.clients.push(data)
    },
    DELETE_CLIENTS_STATE: (state, id) => {
        state.clients = state.clients.filter(item => item.id !== id)
    },
    UPDATE_CLIENTS_STATE: (state, data) => {
        state.clients = state.clients.map(
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