<template>
	<nav class="navbar navbar-expand-sm navbar-light shadow rounded-bottom mb-4">
		<router-link :to="{ name: 'home' }" exact class="navbar-brand">
			<img src="../assets/logo.png" width="30" height="30" alt="">
		</router-link>
		<button class="navbar-toggler px-2 py-1" type="button" data-toggle="collapse" data-target="#navbar-content" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbar-content">
			<ul class="navbar-nav mr-auto mt-2 mt-sm-0">
				<li class="nav-item"><router-link :to="{ name: 'home' }" exact class="nav-link px-2">Home</router-link></li>
				<li class="nav-item"><router-link :to="{ name: 'chat' }" exact class="nav-link px-2">Chat</router-link></li>
				<li class="nav-item"><router-link :to="{ name: 'pms' }" exact class="nav-link px-2">Private Messages</router-link></li>
			</ul>
			<ul class="navbar-nav">
				<li v-if="UserStore.user.authenticated" class="nav-item dropdown">
					<a class="nav-link dropdown-toggle px-2" href="#" id="actions-navbar" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</a>
					<div class="dropdown-menu px-4 py-1" aria-labelledby="actions-navbar">
						<a class="dropdown-item rounded px-2 py-2" href="#" @click.prevent="logout()">Logout</a>
					</div>
				</li>
				<template v-else>
					<li class="nav-item"><router-link :to="{ name: 'login' }" exact class="nav-link px-2">Login</router-link></li>
					<li class="nav-item"><router-link :to="{ name: 'register' }" exact class="nav-link px-2">Register</router-link></li>
				</template>
			</ul>
		</div>
	</nav>
</template>

<script>
	import Flash from '../mixins/Flash'
	import { getHeader, logoutUrl, clearTokens } from '../config'
	import { mapState } from 'vuex'

	export default {
		methods: {
			logout () {
				this.$http.get(logoutUrl, { headers: getHeader() }).then(response => {
					localStorage.removeItem('tokens')

					clearTokens()
					this.$store.dispatch('clearUser')

					this.$router.push({ name: 'home' })

					this.flash(this.generateFlashString('Logged out, See you later'), 'success', {
						timeout: 3000
					})
				})
			}
		},
		computed: {
			...mapState({
				UserStore: state => state.UserStore
			})
		},
		mixins: [Flash]
	}
</script>

<style scoped>
	nav {
		margin: 0 -15px;
	}

	nav li.dropdown .dropdown-menu {
		right: 0;
		left: initial;
	}

	.navbar .navbar-nav .nav-item .nav-link.router-link-active {
		border-radius: 0.25rem;
		background-color: #007bff;
		color: #fff;
	}

	@media (max-width: 575.98px) {
		nav div.navbar-collapse {
			margin: 0.5rem -15px 0;
			border-top: 1px solid rgba(0, 0, 0, 0.1);
		}
	}
</style>