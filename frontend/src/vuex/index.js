import Vue from "vue";
import Vuex from "vuex";
import schedule from "./modules/schedule"
import groups from "./modules/groups"

Vue.use(Vuex)

let store = new Vuex.Store({
    modules: {
        schedule,
        groups
    }
})

export default store;
