import Vue from 'vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'
import Vuex from 'vuex'
import Vuebar from 'vuebar'
import VueChatScroll from 'vue-chat-scroll'
import VueFlashMessage from 'vue-flash-message';
import '../node_modules/vue-flash-message/dist/vue-flash-message.min.css'
import 'bootstrap'
import '../node_modules/bootstrap/scss/bootstrap.scss'
import App from './App.vue'

import Router from './routes/routes'
import Store from './stores/stores'

Vue.use(VueRouter)
Vue.use(VueResource)
Vue.use(Vuex)
Vue.use(Vuebar)
Vue.use(VueChatScroll)
Vue.use(VueFlashMessage)

Vue.config.productionTip = false

new Vue({
	render: h => h(App),
	router: Router,
	store: Store
}).$mount('#app')