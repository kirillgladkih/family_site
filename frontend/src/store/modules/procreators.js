import axios from "axios"
import _ from 'lodash'
import config from '../config'

let url = `http://${config.host}/api/procreators`;

const state = {
    procreators: []
}
const getters = {
    PROCREATORS: state => state.procreators,
}

const actions = {
    GET_PROCREATORS_API({
        commit
    }) {
        return axios.get(url)
            .then(response => {
                commit('SET_PROCREATORS_STATE', response.data)

                return response.data;
            })
            .catch(response => {
                throw response
            })
    },
    GET_DATEIL_PROCREATORS({
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
    DELETE_PROCREATORS_API({
        commit
    }, id) {
        return axios.delete(`${url}/${id}`)
            .then(response => {
                commit('DELETE_PROCREATORS_STATE', id)
                return response.data;
            })
            .catch(response => {
                throw response
            })
    },

    SAVE_PROCREATORS_API({
        commit
    }, data) {
        return axios.post(url, data)
            .then(response => {
                commit('PUSH_PROCREATORS_STATE', response.data)

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

    UPDATE_PROCREATORS_API({
        commit
    }, data) {
        return axios.put(`${url}/${data.id}`, data)
            .then(response => {
                commit('UPDATE_PROCREATORS_STATE', response.data)

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
    SET_PROCREATORS_STATE: (state, data) => {
        state.procreators = data
    },
    PUSH_PROCREATORS_STATE: (state, data) => {
        state.procreators.push(data)
    },
    DELETE_PROCREATORS_STATE: (state, id) => {
        state.procreators = state.procreators.filter(item => item.id !== id)
    },
    UPDATE_PROCREATORS_STATE: (state, data) => {
        state.procreators = state.procreators.map(
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
