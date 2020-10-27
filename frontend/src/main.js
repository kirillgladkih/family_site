import Vue from 'vue'
import App from './App.vue'
import router from './router'
import VueMask from 'v-mask'
import {
  BootstrapVue,
  IconsPlugin
} from 'bootstrap-vue'
import store from './store'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'vue-search-select/dist/VueSearchSelect.css'

Vue.config.productionTip = false
Vue.use(VueMask);
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)


new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')