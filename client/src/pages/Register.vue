<template>
	<card>
		<template slot="header-title">New here? Create an account...</template>
		<template slot="body-inputs">
			<div class="form-group">
				<input type="text" class="form-control" v-model="user.name" placeholder="Full name">
			</div>
			<div class="form-group">
				<input type="email" class="form-control" v-model="user.email" placeholder="Email address">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" v-model="user.password" placeholder="Password">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" v-model="user.passwordConfirmation" placeholder="Password confirmation">
			</div>
		</template>
		<button slot="submit-button" class="btn btn-primary" @click="register()">Register</button>
	</card>
</template>

<script>
	import Card from '../components/Card.vue'
	import { registerUrl } from '../config'
	import DoLogin from '../mixins/Login'
	import Flash from '../mixins/Flash'

	export default {
		components: {
			card: Card
		},
		data () {
			return {
				user: {
					name: null,
					email: null,
					password: null,
					passwordConfirmation: null
				}
			}
		},
		methods: {
			register () {
				var data = {
					name: this.user.name,
					email: this.user.email,
					password: this.user.password,
					password_confirmation: this.user.passwordConfirmation
				}

				this.$http.post(registerUrl, data).then(response => {
					if (response.status == 201) {
						this.doLogin(data.email, data.password).then(response => {
							if (response.status == 200) {
								this.flash(this.generateFlashString('Welcome "' + response.body.name + '" !'), 'success', {
									timeout: 3000
								})
							}
						})
					}
				}, response => {
					if (response.status == 422) { // Validation errors
						this.flash(this.generateFlashString(response.body.message, response.body.errors), 'error', {
							timeout: 7000
						})
					}
				})
			}
		},
		mixins: [DoLogin, Flash]
	}
</script>

<style>
</style>