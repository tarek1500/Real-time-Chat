import Flash from './Flash'
import { getHeader, userInfoUrl } from '../config'

export default {
	methods: {
		userInfo () {
			this.$http.get(userInfoUrl, { headers: getHeader() }).then(response => {
				this.$store.dispatch('setUser', {
					name: response.body.name,
					email: response.body.email
				})

				this.flash(this.generateFlashString('Welcome "' + response.body.name + '" !'), 'success', {
					timeout: 3000
				})
			})
		}
	},
	mixins: [Flash]
}