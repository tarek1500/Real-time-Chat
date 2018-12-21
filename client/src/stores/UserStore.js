const state = {
	user: {
		name: null,
		email: null,
		authenticated: false
	}
}

const mutations = {
	setUser (state, user) {
		state.user.name = user.name
		state.user.email = user.email
		state.user.authenticated = true
	},
	clearUser (state) {
		state.user.name = null
		state.user.email = null
		state.user.authenticated = false
	}
}

const actions = {
	setUser ({ commit }, user) {
		commit('setUser', user)
	},
	clearUser ({ commit }) {
		commit('clearUser')
	}
}

export default {
	state, mutations, actions
}