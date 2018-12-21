import Vue from 'vue'
import Vuex from 'vuex'

import UserStore from './UserStore'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

const Store = new Vuex.Store({
	modules: {
		UserStore
	},
	strict: debug
})

export default Store