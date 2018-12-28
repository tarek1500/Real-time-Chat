<template>
	<div class="text-center">
		<div class="form-group">
			<multi-select :multiple="true" :close-on-select="false" track-by="id" label="name" :options="users" v-model="selectedUsers" placeholder="Select user..."></multi-select>
		</div>
		<div class="form-group">
			<input class="form-control" type="text" v-model="title" placeholder="Enter a title">
		</div>
		<div class="form-group">
			<textarea class="form-control" rows="5" v-model="message" placeholder="Type a message..."></textarea>
		</div>
		<button class="btn btn-primary" @click="send()">Send</button>
	</div>
</template>

<script>
	import Multiselect from 'vue-multiselect'
	import '../../node_modules/vue-multiselect/dist/vue-multiselect.min.css'
	import Flash from '../mixins/Flash'
	import { getHeader, usersUrl, sendMessageUrl } from '../config'

	export default {
		components: {
			'multi-select': Multiselect
		},
		data () {
			return {
				users: [],
				selectedUsers: [],
				title: '',
				message: ''
			}
		},
		methods: {
			send() {
				let data = {
					users: this.selectedUsers.map(user => user.id),
					title: this.title,
					message: this.message
				}

				this.$http.post(sendMessageUrl, data, { headers: getHeader() }).then(response => {
					this.title = '',
					this.message = ''

					this.flash(this.generateFlashString('Message sent successfully !'), 'info', {
						timeout: 3000
					})
				}, response => {
					if (response.status == 422) { // Validation errors
						this.flash(this.generateFlashString(response.body.message, response.body.errors), 'error', {
							timeout: 7000
						})
					}
				})
			}
		},
		created() {
			this.$http.get(usersUrl, { headers: getHeader() }).then(response => {
				this.users = response.body.users
			})
		},
		mixins: [Flash]
	}
</script>

<style scoped>
	textarea {
		resize: none;
	}
</style>