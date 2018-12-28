<template>
	<messages-table>
		<template slot="sender-type">From</template>
		<tr v-for="message in messages" slot="message" :class="{ new: !message.read }" @click="showMessage(message.id)">
			<td>{{ message.sender.name }}</td>
			<td>{{ message.title }}</td>
			<td>{{ message.created_at_string }}</td>
		</tr>
	</messages-table>
</template>

<script>
	import MessagesTable from './MessagesTable.vue'
	import Flash from '../mixins/Flash'
	import { getHeader, getInboxUrl, showMessageUrl, pusherEndpointUrl, pusherKey, pusherCluster, pusherHost, pusherPort } from '../config'

	export default {
		components: {
			'messages-table': MessagesTable
		},
		data () {
			return {
				echo: null,
				channel: null,
				messages: {}
			}
		},
		methods: {
			showMessage (id) {
				let data = {
					message: id
				}

				this.$http.post(showMessageUrl, data, { headers: getHeader() }).then(response => {
					this.$emit('showMessage', response.body.message)
				}, response => {
					if (response.status == 422) { // Validation errors
						this.flash(this.generateFlashString(response.body.message, response.body.errors), 'error', {
							timeout: 7000
						})
					}
					else if (response.status == 404) { // Not authorized message
						this.flash(this.generateFlashString('Message not found !'), 'warning', {
							timeout: 3000
						})
					}
				})
			}
		},
		created () {
			window.localStorage.clear() // To let pusher re-connect to Websocket on every startup

			this.echo = new Echo({
				broadcaster: 'pusher',
				key: pusherKey,
				cluster: pusherCluster,
				wsHost: pusherHost,
				wsPort: pusherPort,
				disableStats: true,
				authEndpoint: pusherEndpointUrl,
				auth: {
					headers: getHeader()
				}
			})

			this.$http.get(getInboxUrl, { headers: getHeader() }).then(response => {
				this.messages = response.body.messages
				this.channel = response.body.channel

				this.echo.private(this.channel).listen('PrivateMessageEvent', event => {
					this.messages.unshift(event.message)
				})
			})
		},
		destroyed () {
			if (this.channel)
				this.echo.leave(this.channel)
		},
		mixins: [Flash]
	}
</script>

<style>
</style>