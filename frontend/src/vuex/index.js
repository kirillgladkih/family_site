import Vue from "vue";
import Vuex from "vuex";
import schedule from "./modules/schedule"
import groups from "./modules/groups"
import procreators from "./modules/procreators"
import clients from "./modules/clients"

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        schedule,
        groups,
        procreators,
        clients
    }
})

export default store;
