<template>
	<div class="row">
		<div class="col-md-4 col-lg-3 mb-4 mb-md-0">
			<div class="list-group">
				<sidebar @click.native="changeComponent('send')"><template slot="list-item">Send Message</template></sidebar>
				<sidebar @click.native="changeComponent('inbox')"><template slot="list-item">Inbox</template></sidebar>
				<sidebar @click.native="changeComponent('sent')"><template slot="list-item">Sent</template></sidebar>
			</div>
		</div>
		<div class="col-md-8 col-lg-9">
			<scroll-bar class="fixed-height">
				<div slot="content">
					<component :is="component" v-bind="messageProps" @showMessage="show"></component>
				</div>
			</scroll-bar>
		</div>
	</div>
</template>

<script>
	import SidebarList from '../components/SidebarList.vue'
	import ScrollBar from '../components/ScrollBar.vue'
	import SendMessage from '../components/SendMessage.vue'
	import Inbox from '../components/Inbox.vue'
	import Sent from '../components/Sent.vue'
	import ShowMessage from '../components/ShowMessage.vue'
	import Vue from 'vue'

	export default {
		components: {
			sidebar: SidebarList,
			'scroll-bar': ScrollBar,
			message: null
		},
		data () {
			return {
				component: null
			}
		},
		methods: {
			changeComponent (component) {
				if (component == 'send')
					this.component = SendMessage
				else if (component == 'inbox')
					this.component = Inbox
				else if (component == 'sent')
					this.component = Sent
			},
			show (message) {
				this.message = message
				this.component = ShowMessage
			}
		},
		computed: {
			messageProps () {
				if (this.component == ShowMessage)
					return {
						message: this.message
					}
			}
		}
	}
</script>

<style scoped>
	.fixed-height {
		height: calc(100vh - 59px - 3rem);	/* Navbar height - (top, bottom) margin */
	}

	@media (max-width: 767.98px) {
		.fixed-height {
			height: calc(100vh - 59px - 148px - 4.5rem);	/* Navbar height - Sidebar List height - (Sidebar List bottom, top, bottom) margin */
		}
	}
</style>