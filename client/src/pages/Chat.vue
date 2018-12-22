<template>
	<div class="row">
		<div class="col-3">
			<scroll-bar class="fixed-height">
				<div slot="content" class="list-group">
					<sidebar v-for="user in users" @click.native="showChat(user.id)"><template slot="list-item">{{ user.name }}</template></sidebar>
				</div>
			</scroll-bar>
		</div>
		<div class="col-9">
			<scroll-bar class="fixed-height">
				<div slot="content" v-chat-scroll="{ always: false, smooth: true }">
					<template v-if="UserStore.chatUser">
						<message v-for="chat in chats" :class="chat.sender_id == UserStore.chatUser ? 'float-right' : 'float-left'">
							<template slot="message-from">{{ chat.sender.name }}</template>
							<template slot="message-time">{{ chat.created_at_string }}</template>
							<template slot="message-body">{{ chat.message }}</template>
						</message>
						<div class="clearfix"></div>
						<div class="form-group send-message">
							<input class="form-control" type="text" placeholder="Type a message..." v-model="message" @keyup.enter="send()">
						</div>
					</template>
				</div>
			</scroll-bar>
		</div>
	</div>
</template>

<script>
	import ScrollBar from '../components/ScrollBar.vue'
	import SidebarList from '../components/SidebarList.vue'
	import ChatMessage from '../components/ChatMessage.vue'
	import { getHeader, usersUrl, getChatUrl, sendChatUrl } from '../config'
	import { mapState } from 'vuex'

	export default {
		components: {
			'scroll-bar': ScrollBar,
			sidebar: SidebarList,
			message: ChatMessage
		},
		data () {
			return {
				users: {},
				chats: {},
				message: ''
			}
		},
		methods: {
			showChat (id) {
				if (id != this.UserStore.chatUser) {
					let data = {
						id: id
					}

					this.$http.post(getChatUrl, data, { headers: getHeader() }).then(response => {
						this.$store.dispatch('setChatUser', id)
						this.chats = response.body.chats
					})
				}
			},
			send () {
				if (this.message) {
					let data = {
						id: this.UserStore.chatUser,
						message: this.message
					}

					this.$http.post(sendChatUrl, data, { headers: getHeader() }).then(response => {
						this.message = ''
					})
				}
			}
		},
		computed: {
			...mapState({
				UserStore: state => state.UserStore
			})
		},
		created () {
			this.$http.get(usersUrl, { headers: getHeader() }).then(response => {
				this.users = response.body.users
			})
		}
	}
</script>

<style scoped>
	.fixed-height {
		height: calc(100vh - 59px - 24px - 24px);	/* Navbar height - top margin - bottom margin */
	}

	.send-message {
		margin-top: 20px;
	}
</style>