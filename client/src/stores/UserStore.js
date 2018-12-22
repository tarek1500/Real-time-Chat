const state = {
	user: {
		name: null,
		email: null,
		authenticated: false
	},
	chatUser: null
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
	},
	setChatUser (state, chatUser) {
		state.chatUser = chatUser
	}
}

const actions = {
	setUser ({ commit }, user) {
		commit('setUser', user)
	},
	clearUser ({ commit }) {
		commit('clearUser')
	},
	setChatUser ({ commit }, chatUser) {
		commit('setChatUser', chatUser)
	}
}

export default {
	state, mutations, actions
}