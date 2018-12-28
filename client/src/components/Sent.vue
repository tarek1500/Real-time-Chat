<template>
	<messages-table>
		<template slot="sender-type">To</template>
		<tr v-for="message in messages" slot="message" :class="{ new: !message.read }" @click="showMessage(message.id)">
			<td>{{ message.receiver.name }}</td>
			<td>{{ message.title }}</td>
			<td>{{ message.created_at_string }}</td>
		</tr>
	</messages-table>
</template>

<script>
	import MessagesTable from './MessagesTable.vue'
	import Flash from '../mixins/Flash'
	import { getHeader, getOutboxUrl, showMessageUrl } from '../config'

	export default {
		components: {
			'messages-table': MessagesTable
		},
		data () {
			return {
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
					else if (response.status == 404) { // Not related message
						this.flash(this.generateFlashString('Message not found !'), 'warning', {
							timeout: 3000
						})
					}
				})
			}
		},
		created () {
			this.$http.get(getOutboxUrl, { headers: getHeader() }).then(response => {
				this.messages = response.body.messages
			})
		},
		mixins: [Flash]
	}
</script>

<style>
</style>