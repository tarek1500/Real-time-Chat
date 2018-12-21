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
		</template>
		<button slot="submit-button" class="btn btn-primary" @click="login()">Login</button>
	</card>
</template>

<script>
	import Card from '../components/Card.vue'
	import DoLogin from '../mixins/Login'
	import Flash from '../mixins/Flash'

	export default {
		components: {
			card: Card
		},
		data () {
			return {
				email: '',
				password: ''
			}
		},
		methods: {
			login () {
				this.doLogin(this.email, this.password).then(response => {
					if (response.status == 200) {
						this.flash(this.generateFlashString('Welcome "' + response.body.name + '" !'), 'success', {
							timeout: 3000
						})
					}
					else if (response.body.error == 'invalid_request' ||	 // Empty username / password
							 response.body.error == 'invalid_credentials') { // Wrong username / password
						let hint = null

						if (response.body.hint)
							hint = { login: [response.body.hint] }

						this.flash(this.generateFlashString(response.body.message, hint), 'warning', {
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