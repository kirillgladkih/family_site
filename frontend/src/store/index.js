import Vue from "vue";
import Vuex from "vuex";
import schedule from "./modules/schedule"
import client_schedule from "./modules/client_schedule"
import groups from "./modules/groups"
import procreators from "./modules/procreators"
import clients from "./modules/clients"
import records from './modules/records'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {},
  mutations: {},
  actions: {},
  modules: {
    schedule,
    groups,
    procreators,
    clients,
    client_schedule,
    records
  }
})