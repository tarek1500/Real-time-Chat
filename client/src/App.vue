<template>
	<div class="container-fluid">
		<navbar></navbar>
		<flash></flash>
		<router-view></router-view>
	</div>
</template>

<script>
	import Navbar from './components/Navbar.vue'
	import FlashMessage from './components/FlashMessage.vue'
	import { checkTokenUrl, refreshTokenUrl, setTokens } from './config'
	import User from './mixins/User'

	export default {
		components: {
			navbar: Navbar,
			flash: FlashMessage
		},
		created () {
			if (localStorage.getItem('tokens')) {
				let tokens = JSON.parse(localStorage.getItem('tokens'))
				let data = {
					access_token: tokens.access_token
				}

				this.$http.post(checkTokenUrl, data).then(response => {
					if (response.body.valid) {
						setTokens(tokens.access_token, tokens.refresh_token)
						this.userInfo()

						this.$router.push({ name: 'home' })
					}
					else {
						let data = {
							access_token: tokens.access_token,
							refresh_token: tokens.refresh_token
						}

						this.$http.post(refreshTokenUrl, data).then(response => {
							let access_token = response.body.access_token, refresh_token = response.body.refresh_token

							localStorage.setItem('tokens', JSON.stringify({
								access_token: access_token,
								refresh_token: refresh_token
							}))

							setTokens(access_token, refresh_token)
							this.userInfo()

							this.$router.push({ name: 'home' })
						}, response => {
							localStorage.removeItem('tokens')
						})
					}
				})
			}
		},
		mixins: [User]
	}
</script>

<style>
</style>