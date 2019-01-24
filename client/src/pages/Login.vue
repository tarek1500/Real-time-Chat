<template>
	<card>
		<template slot="header-title">Login to your account...</template>
		<template slot="body-inputs">
			<div class="form-group">
				<input type="email" class="form-control" v-model="email" placeholder="Enter email">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" v-model="password" placeholder="Password">
			</div>
			<div class="form-check form-group">
				<input type="checkbox" class="form-check-input" id="remember-me" v-model="remember">
				<label class="form-check-label" for="remember-me">Remember Me</label>
			</div>
		</template>
		<button slot="submit-button" class="btn btn-primary" @click="login()">Login</button>
	</card>
</template>

<script>
	import Card from '../components/Card.vue'
	import { loginUrl, setTokens } from '../config'
	import Flash from '../mixins/Flash'
	import User from '../mixins/User'

	export default {
		components: {
			card: Card
		},
		data () {
			return {
				email: '',
				password: ''
				remember: true
			}
		},
		methods: {
			login () {
				let data = {
					email: this.email,
					password: this.password
				}

				this.$http.post(loginUrl, data).then(response => {
					let access_token = response.body.access_token, refresh_token = response.body.refresh_token

					if (this.remember) {
						localStorage.setItem('tokens', JSON.stringify({
							access_token: access_token,
							refresh_token: refresh_token
						}))
					}
					else
						localStorage.removeItem('tokens')

					setTokens(access_token, refresh_token)
					this.userInfo()

					this.$router.push({ name: 'home' })
				}, response => {
					if (response.status == 422) { // Validation errors
						this.flash(this.generateFlashString(response.body.message, response.body.errors), 'error', {
							timeout: 7000
						})
					}
					else if (response.status == 401) { // Invalid credentials
						this.flash(this.generateFlashString(response.body.message), 'warning', {
							timeout: 3000
						})
					}
				})
			}
		},
		mixins: [User, Flash]
	}
</script>

<style>
</style>