import axios from "axios"
import _ from 'lodash'

let url = `http://${location.hostname}/api/schedule`;
let headers = { "Access-Control-Allow-Origin": "*" }


const state = {
    schedule: [],
    schedule_days: [],
    hours: [],
    client_schedule: [],
    timetable : []
}
const getters = {
    CLIENT_SCHEDULE(state) {
        return state.client_schedule
    },
    SCHEDULE(state) {
        return state.schedule
    },
    SCHEDULE_DAYS(state) {
        return state.schedule_days
    }
    ,
    HOURS_DAYS(state) {
        return state.hours
    }, 
    TIMETABLE(state){
        return state.timetable
    }
}

const actions = {

    GET_CLIENT_SCHEDULE_DAYS_FROM_API({ commit }, data) {
        let subUrl = `http://${location.hostname}/api/sch/record_days/${data.id}/`;
        return axios.get(subUrl, { headers: headers })
            .then(response => {
                commit('SET_SCHEDULE_DAYS_TO_STATE', response.data)
            })
            .catch(response => {
                throw response
            })
    },

    GET_TIMETABLE_FROM_API({commit}, data){
        let subUrl = `http://${location.hostname}/api/schedule/timetable/${data.date}/${data.group_id}/`;
        return axios.get(subUrl, { headers: headers })
            .then(response => {
                commit('SET_TIMETABLE_TO_STATE', response.data)
            })
            .catch(response => {
                throw response
            })
    },

    GET_CLIENT_HOURS_FROM_API({ commit }, data) {
        let subUrl = `http://${location.hostname}/api/sch/record_hours/${data.id}/${data.date}`;
        return axios.get(subUrl)
            .then(response => {
                commit('SET_HOURS_TO_STATE', response.data)
            })
            .catch(response => {
                throw response
            })
    },

    GET_SCHEDULE_FROM_API({ commit }, data) {
        let subUrl = `${url}/getDay/${data.day}/${data.group_id}/${data.start}/${data.end}`

        return axios.get(subUrl)
            .then(response => {
                commit('SET_SCHEDULE_TO_STATE', response.data)
                return response
            })
            .catch(response => {
                return response
            })
    },


    CLEAR_CLIENT_SCHEDULE({ commit }) {
        commit('CLEAR_CLIENT_SCHEDULE_TO_STATE')
    },

    CLEAR_SCHEDULE({ commit }) {
        commit('CLEAR_SCHEDULE_TO_STATE')
    },

    CLEAR_TIMETABLE({ commit }) {
        commit('CLEAR_TIMETABLE_TO_STATE')
    },

    GET_CLIENT_SCHEDULE_FROM_API({ commit }, data) {
        let subUrl = `http://${location.hostname}/api/client-schedule/${data.client_id}/${data.day}/${data.start}/${data.end}`

        return axios.get(subUrl)
            .then(response => {
                commit('SET_CLIENT_SCHEDULE_TO_STATE', response.data)
                return response
            })
            .catch(response => {
                throw response
            })
    },

    EDIT_CLIENT_SCHEDULE_FROM_API({ commit }, data) {
        let subUrl = `http://${location.hostname}/api/client-schedule`

        return axios.post(subUrl, data)
            .then(response => {
                commit('UPDATE_CLIENT_SCHEDULE_TO_STATE', response.data)
                return response
            })
            .catch(response => {
                throw response
            })
    },

    ADD_SCHEDULE_FROM_API({ commit }, data) {
        return axios.post(url, data)
            .then(response => {
                commit('SET_SCHEDULE_TO_STATE', response.data)
                return response
            })
            .catch(response => {
                throw response
            })
    },

    EDIT_SCHEDULE_FROM_API({ commit }, item) {
        return axios.put(`${url}/${item.id}`, item)
            .then(response => {
                commit('UPDATE_SCHEDULE_TO_STATE', item)
                return response
            })
            .catch(response => {
                throw response
            })
    },
}


const mutations = {
    SET_SCHEDULE_TO_STATE: (state, data) => {
        state.schedule = data;
    },

    CLEAR_SCHEDULE_TO_STATE(state) {
        state.schedule = []
    },

    CLEAR_TIMETABLE_TO_STATE(state){
        state.timetable = []
    },

    SET_HOURS_TO_STATE: (state, data) => {
        state.hours = []
        state.hours = data
    },

    SET_TIMETABLE_TO_STATE: (state, data) => {
        state.timetable = data
    },

    SET_SCHEDULE_DAYS_TO_STATE: (state, data) => {
        state.schedule_days = data
    },

    CLEAR_CLIENT_SCHEDULE_TO_STATE: (state) => {
        state.client_schedule = []
    },

    SET_CLIENT_SCHEDULE_TO_STATE: (state, data) => {
        state.client_schedule = data
    },

    UPDATE_CLIENT_SCHEDULE_TO_STATE: (state, item) => {
        state.client_schedule = state.client_schedule.map(obj => {
            if (obj.id === item.id) {
                return item
            }
            return obj
        })
    },

    SET_SCHEDULE_ITEM_TO_STATE: (state, data) => {
        state.schedule_days.push(data)
    },
    UPDATE_SCHEDULE_TO_STATE: (state, item) => {
        state.schedule = state.schedule.map(obj => {
            if (obj.id === item.id) {
                return item
            }
            return obj
        })
    },
}
// const actions = {
//     GET_GROUPS_FROM_API({commit}) {
//         return axios.get(url)
//             .then(response => {
//                 commit('SET_GROUPS_TO_STATE', response.data)
//                 return response
//             })
//             .catch(response => {
//                 return response
//             })
//     },
//     ADD_GROUP_FROM_API({commit}, group) {
//         return axios.post(url, group)
//             .then(response => {
//                 commit('SET_GROUP_TO_STATE', response.data)
//                 return response
//             })
//             .catch(response => {
//                 throw response
//             })
//     },
//     EDIT_GROUP_FROM_API({commit}, group) {
//         return axios.put(`${url}/${group.id}`, group)
//             .then(response => {
//                 commit('UPDATE_GROUP_TO_STATE', group)
//                 return response
//             })
//             .catch(response => {
//                 throw response
//             })
//     },

//     DELETE_GROUP_FROM_API({commit}, id) {
//         return axios.delete(`${url}/${id}`)
//             .then(response => {
//                 commit('DELETE_GROUP_TO_STATE', id)
//                 return response
//             })
//             .catch(response => {
//                 return response
//             })
//     }

// }

export default {
    state,
    getters,
    mutations,
    actions
}
