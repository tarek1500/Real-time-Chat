<template>
	<nav class="navbar navbar-expand-lg navbar-light shadow mb-4 rounded-bottom">
		<router-link :to="{ name: 'home' }" exact class="navbar-brand">
			<img src="../assets/logo.png" width="30" height="30" alt="">
		</router-link>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-content" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbar-content">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item"><router-link :to="{ name: 'home' }" exact class="nav-link">Home</router-link></li>
				<li class="nav-item"><router-link :to="{ name: 'chat' }" exact class="nav-link">Chat</router-link></li>
				<li class="nav-item"><router-link :to="{ name: 'pms' }" exact class="nav-link">Private Messages</router-link></li>
			</ul>
			<ul class="navbar-nav my-2 my-lg-0">
				<li v-if="UserStore.user.authenticated" class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="actions-navbar" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</a>
					<div class="dropdown-menu" aria-labelledby="actions-navbar">
						<a class="dropdown-item" href="#" @click.prevent="logout()">Logout</a>
					</div>
				</li>
				<template v-else>
					<li class="nav-item"><router-link :to="{ name: 'login' }" exact class="nav-link">Login</router-link></li>
					<li class="nav-item"><router-link :to="{ name: 'register' }" exact class="nav-link">Register</router-link></li>
				</template>
			</ul>
		</div>
	</nav>
</template>

<script>
	import Flash from '../mixins/Flash'
	import { clearTokens } from '../config'
	import { mapState } from 'vuex'

	export default {
		methods: {
			logout () {
				clearTokens()
				this.$store.dispatch('clearUser')

				this.$router.push({ name: 'home' })

				this.flash(this.generateFlashString('Logged out, See you later'), 'success', {
					timeout: 3000
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
</style>