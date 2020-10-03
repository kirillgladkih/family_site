import axios from "axios"
import _ from 'lodash'

let url = `http://${location.hostname}/api/schedule`;

const state = {
    schedule: [],
    weeks: []
}
const getters = {
    SCHEDULE: state => state.schedule,
    WEEKS: state => state.weeks,
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
    async GET_SCHEDULE_API({
        commit
    }, data) {
        return await axios.get(`${url}/${data.week_id}/${data.group_id}`)
            .then(response => {
                commit('SET_SCHEDULE_STATE', response.data)
                return response.data;
            })
            .catch(response => {
                throw response
            })
    },
    async GET_DATEIL_SCHEDULE({
        commit
    }, id) {
       return await axios.get(`${url}/${id}`)
            .then(response => {
                return response.data;
            })
            .catch(response => {
                throw response
            })
    },
    async GET_WEEKS_API({
        commit
    }) {
        return await axios.get(`http://${location.hostname}/api/weeks`)
            .then(response => {
                const data = response.data
                commit('SET_WEEKS_STATE', data)
                return data;
            })
            .catch(response => {
                throw makeErrors(response)
            })
    },

    DELETE_SCHEDULE_API({
        commit
    }, id) {
        return axios.delete(`${url}/${id}`)
            .then(response => {
                commit('DELETE_SCHEDULE_STATE', id)

                return response.data;
            })
            .catch(response => {
                throw response
            })
    },

    // SAVE_SCHEDULE_API({
    //     commit
    // }, data) {
    //     return axios.post(url, data)
    //         .then(response => {
    //             commit('PUSH_SCHEDULE_STATE', response.data)

    //             return response.data;
    //         })
    //         .catch(response => {
    //             let tmp = response.response.data.errors
    //             let errors = []
    //             _.forEach(tmp, function (value) {
    //                 errors.push(value[0])
    //             });
    //             throw errors
    //         })
    // },

    async UPDATE_SCHEDULE_API({
        commit
    }, data) {
        return await axios.put(url, data)
            .then(response => {
                commit('UPDATE_SCHEDULE_STATE', response.data)
                return response.data;
            })
            .catch(response => {
                throw makeErrors(response)
            })
    },

}

const mutations = {
    SET_SCHEDULE_STATE: (state, data) => {
        state.schedule = data
    },
    SET_WEEKS_STATE: (state, data) => {
        state.weeks = data
    },
    // PUSH_SCHEDULE_STATE: (state, data) => {
    //     state.SCHEDULE.push(data)
    // },
    // DELETE_SCHEDULE_STATE: (state, id) => {
    //     state.SCHEDULE = state.SCHEDULE.filter(item => item.id !== id)
    // },
    UPDATE_SCHEDULE_STATE: (state, data) => {
        state.schedule[data.hour.hour] = state.schedule[data.hour.hour].map(
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
