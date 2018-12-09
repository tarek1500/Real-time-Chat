import Vue from 'vue'
import VueRouter from 'vue-router'
import 'bootstrap'
import '../node_modules/bootstrap/scss/bootstrap.scss'
import App from './App.vue'

import Router from './routes/routes'

Vue.use(VueRouter);

Vue.config.productionTip = false

new Vue({
	render: h => h(App),
	router: Router
}).$mount('#app')