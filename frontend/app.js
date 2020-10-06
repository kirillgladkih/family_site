import Vue from 'vue'
import VueRouter from 'vue-router'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import App from './src/views/App'
import routes from './src/routes/index'
import store from "./src/vuex/index";
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueRouter)

const router = new VueRouter({
    routes,
    mode: 'history'
});

const app = new Vue({
    render: h => h(App),
    router,
    store,
}).$mount('#app')
