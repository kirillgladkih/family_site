import Vue from "vue";
import Vuex from "vuex";
import schedule from "./modules/schedule"

Vue.use(Vuex)

let store = new Vuex.Store({
    modules: {
        schedule
    }
})

export default store;
