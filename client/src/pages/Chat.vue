<template>
	<div class="row">
		<div class="col-3">
			<scroll-bar class="fixed-height">
				<div slot="content" class="list-group">
					<sidebar v-for="user in users" @click.native="showChat(user.id, user.name)"><template slot="list-item">{{ user.name }}</template></sidebar>
				</div>
			</scroll-bar>
		</div>
		<div class="col-9">
			<scroll-bar class="fixed-height">
				<div slot="content" v-chat-scroll="{ always: false, smooth: true }">
					<div v-show="user.id">
						<span class="status" ref="status">Offline</span>
						<message v-for="chat in chats" :class="chat.sender_id == user.id ? 'float-right' : 'float-left'">
							<template slot="message-from">{{ chat.sender.name }}</template>
							<template slot="message-time">{{ chat.created_at_string }}</template>
							<template slot="message-body">{{ chat.message }}</template>
						</message>
						<div class="clearfix"></div>
						<div class="form-group send-message">
							<span v-show="user.typing" ref="typing">{{ user.name }} is typing...</span>
							<input class="form-control" type="text" placeholder="Type a message..." v-model="message" @keyup.enter="send()">
						</div>
					</div>
				</div>
			</scroll-bar>
		</div>
	</div>
</template>

<script>
	import ScrollBar from '../components/ScrollBar.vue'
	import SidebarList from '../components/SidebarList.vue'
	import ChatMessage from '../components/ChatMessage.vue'
	import { getHeader, usersUrl, getChatUrl, sendChatUrl, pusherEndpointUrl, pusherKey, pusherCluster, pusherHost, pusherPort } from '../config'

	export default {
		components: {
			'scroll-bar': ScrollBar,
			sidebar: SidebarList,
			message: ChatMessage
		},
		data () {
			return {
				echo: null,
				channel: null,
				users: {},
				chats: {},
				message: '',
				user: {
					id: null,
					name: null,
					online: false,
					typing: false
				}
			}
		},
		watch: {
			message () {
				this.echo.join(this.channel).whisper('typing', {
					typing: this.message ? true : false
				})
			},
			'user.online' () {
				if (this.user.online)
					this.$refs.status.textContent = 'Online'
				else
					this.$refs.status.textContent = 'Offline'

				this.$refs.status.classList.toggle('online')
			}
		},
		methods: {
			showChat (id, name) {
				if (id != this.user.id) {
					if (this.channel)
						this.echo.leave(this.channel)

					this.user.name = name
					this.user.typing = false
					this.$refs.typing.style.setProperty('--width', ((this.user.name.length + 14) * 10) + 'px')
					let data = {
						id: id
					}

					this.$http.post(getChatUrl, data, { headers: getHeader() }).then(response => {
						this.user.id = id
						this.chats = response.body.chats
						this.channel = response.body.channel

						this.echo.join(this.channel).here(users => {
							this.user.online = false
							users.forEach(user => {
								if (user.id == this.user.id)
									this.user.online = true
							})
						}).joining(user => {
							if (user.id == this.user.id)
								this.user.online = true
						}).leaving(user => {
							if (user.id == this.user.id) {
								this.user.online = false
								this.user.typing = false
							}
						}).listen('ChatEvent', event => {
							this.chats.push(event.chat)
						}).listenForWhisper('typing', event => {
							this.user.typing = event.typing
						})

						this.message = ''
					})
				}
			},
			send () {
				if (this.message) {
					let data = {
						id: this.user.id,
						message: this.message
					}

					this.$http.post(sendChatUrl, data, { headers: getHeader('X-Socket-ID', this.echo.socketId()) }).then(response => {
						this.message = ''
						this.chats.push(response.body.chat)
					})
				}
			}
		},
		created () {
			this.$http.get(usersUrl, { headers: getHeader() }).then(response => {
				this.users = response.body.users
			})

			for (var data in window.localStorage) // To let pusher re-connect to Websocket on every startup
				if (data.startsWith('pusherTransport'))
					window.localStorage.removeItem(data)

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
		},
		destroyed () {
			if (this.channel)
				this.echo.leave(this.channel)
		}
	}
</script>

<style scoped>
	.fixed-height {
		height: calc(100vh - 59px - 24px - 24px);	/* Navbar height - top margin - bottom margin */
	}

	.status {
		position: fixed;
		top: 83px;
		right: 45px;
		display: block;
		font-weight: 500;
		color: red;
	}
	.status::before {
		width: 10px;
		height: 10px;
		margin-right: 4px;
		display: inline-block;
		border-radius: 50%;
		content: '';
		background-color: red;
	}
	.status.online {
		color: green;
	}
	.status.online::before {
		background-color: green;
	}

	.send-message {
		margin-top: 22px;
	}

	.send-message span {
		margin-bottom: 5px;
		display: block;
		overflow: hidden;
		border-right: .15rem solid orange;
		color: gray;
		font-size: 1.5rem;
		white-space: nowrap;
		animation: typing 3.5s steps(40, end) infinite, blink-caret .75s step-end infinite;
	}

	@keyframes typing {
		0%,
		100% {
			width: 0;
		}
		75% {
			width: var(--width);
		}
	}

	@keyframes blink-caret {
		0%,
		100% {
			border-color: transparent;
		}
		50% {
			border-color: orange;
		}
	}
</style>