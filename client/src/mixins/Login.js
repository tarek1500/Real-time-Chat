import { clientId, clientSecret, setTokens, getHeader, loginUrl, userInfoUrl } from '../config'

export default {
	methods: {
		doLogin (username, password) {
			let data = {
				grant_type: 'password',
				client_id: clientId,
				client_secret: clientSecret,
				username: username,
				password: password,
				scope: ''
			}

			return this.$http.post(loginUrl, data).then(response => {
				if (response.status == 200) {
					setTokens(response.body.access_token, response.body.refresh_token)

					return this.$http.get(userInfoUrl, { headers: getHeader() }).then(response => {
						this.$store.dispatch('setUser', {
							name: response.body.name,
							email: response.body.email
						})

						this.$router.push({ name: 'home' })

						return response
					})
				}
			}, response => {
				return response // Return errors to use in components
			})
		}
	}
}