<template>
	<div class="row">
		<div class="col-3">
			<scroll-bar class="fixed-height">
				<div slot="content" class="list-group">
					<sidebar @click="showChat()"><template slot="list-item">User 1</template></sidebar>
					<sidebar @click="showChat()"><template slot="list-item">User 2</template></sidebar>
				</div>
			</scroll-bar>
		</div>
		<div class="col-9">
			<scroll-bar class="fixed-height">
				<div slot="content" v-chat-scroll="{ always: false, smooth: true }">
					<message class="float-left">
						<template slot="message-from">User 1</template>
						<template slot="message-time">5 minutes ago.</template>
						<template slot="message-body">Message Body</template>
					</message>
					<message class="float-right">
						<template slot="message-from">User 2</template>
						<template slot="message-time">4 minutes ago.</template>
						<template slot="message-body">Message Body</template>
					</message>
					<div class="clearfix"></div>
					<div class="form-group send-message">
						<input class="form-control" type="text" placeholder="Type a message..." @click="send">
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

	export default {
		components: {
			'scroll-bar': ScrollBar,
			sidebar: SidebarList,
			message: ChatMessage
		},
		methods: {
			showChat (id) {},
			send () {}
		},
		created () {}
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