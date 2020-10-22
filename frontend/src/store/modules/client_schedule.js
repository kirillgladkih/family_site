import axios from "axios"
import _ from 'lodash'

let url = `http://${location.hostname}/api/client_schedule`;

const state = {
    client_schedule: [],
}
const getters = {
    CLIENT_SCHEDULE: state => state.client_schedule,
}

const makeErrors = response => {
    let tmp = response.response.data.errors
    let errors = []

    _.forEach(tmp, function (value) {
        errors.push(value[0])
    });

    return errors
}

const actions = {
    async GET_CLIENT_SCHEDULE_API({
        commit
    }, id) {
        return await axios.get(`${url}/${id}`)
            .then(response => {
                commit('SET_CLIENT_SCHEDULE_STATE', response.data)
                return response.data;
            })
            .catch(response => {
                throw response
            })
    },

    async UPDATE_CLIENT_SCHEDULE_API({
        commit
    }, data) {
        return await axios.put(url, data)
            .then(response => {
                commit('UPDATE_CLIENT_SCHEDULE_STATE', response.data)
                return response.data;
            })
            .catch(response => {
                throw makeErrors(response)
            })
    },

}

const mutations = {
    SET_CLIENT_SCHEDULE_STATE: (state, data) => {
        state.client_schedule = data
    },
    UPDATE_CLIENT_SCHEDULE_STATE: (state, data) => {
        state.client_schedule[data.hour.hour] = state.client_schedule[data.hour.hour].map(
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
