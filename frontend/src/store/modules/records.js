import axios from "axios"
import _ from 'lodash'
import config from '../config'

let url = `http://${config.host}/api/records`;

const state = {
    records: []
}
const getters = {
    RECORDS: state => state.records,
}

const actions = {
    GET_RECORDS_API({
        commit
    }) {
        return axios.get(url)
            .then(response => {
                commit('SET_RECORDS_STATE', response.data)

                return response.data;
            })
            .catch(response => {
                throw response
            })
    },
    GET_DATEIL_RECORDS({
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
    DELETE_RECORDS_WHERE_API({ commit }, data) {
        let subUrl = `http://${config.host}/api/records_deleteWhere`
        return axios.post(subUrl, data)
            .then(response => {
                return response;
            })
            .catch(response => {
                throw response
            })
    },
    DELETE_RECORDS_API({
        commit
    }, id) {
        return axios.delete(`${url}/${id}`)
            .then(response => {
                commit('DELETE_RECORDS_STATE', id)
                return response.data;
            })
            .catch(response => {
                throw response
            })
    },

    SAVE_RECORDS_API({
        commit
    }, data) {
        return axios.post(url, data)
            .then(response => {
                commit('PUSH_RECORDS_STATE', response.data)

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

    UPDATE_RECORDS_API({
        commit
    }, data) {
        return axios.put(`${url}/${data.id}`, data)
            .then(response => {
                commit('UPDATE_RECORDS_STATE', response.data)

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

    VISIT_RECORDS_API({
        commit
    }, data) {
        return axios.put(`${url}_visit/${data.id}`, data)
            .then(response => {
                commit('DELETE_RECORDS_STATE', data.id)
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

    HISTORY_RECORDS_API({ commit }, data) {
        return axios.get(`${url}_history/${data.id}/${data.before}/${data.after}`, data)
            .then(response => {
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
    }

}

const mutations = {
    SET_RECORDS_STATE: (state, data) => {
        state.records = data
    },
    PUSH_RECORDS_STATE: (state, data) => {
        state.records.push(data)
    },
    DELETE_RECORDS_STATE: (state, id) => {
        state.records = state.records.filter(item => item.id !== id)
    },
    UPDATE_RECORDS_STATE: (state, data) => {
        state.records = state.records.map(
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
