<template>
	<div class="row">
		<div class="col-3">
			<div class="list-group">
				<sidebar @click.native="ChangeComponent('send')"><template slot="list-item">Send Message</template></sidebar>
				<sidebar @click.native="ChangeComponent('inbox')"><template slot="list-item">Inbox</template></sidebar>
				<sidebar @click.native="ChangeComponent('sent')"><template slot="list-item">Sent</template></sidebar>
			</div>
		</div>
		<div class="col-9">
			<scroll-bar class="fixed-height">
				<div slot="content">
					<component :is="component"></component>
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

	export default {
		components: {
			sidebar: SidebarList,
			'scroll-bar': ScrollBar
		},
		data () {
			return {
				component: null
			}
		},
		methods: {
			ChangeComponent (component) {
				if (component == 'send')
					this.component = SendMessage
				else if (component == 'inbox')
					this.component = Inbox
				else if (component == 'sent')
					this.component = Sent
			}
		}
	}
</script>

<style scoped>
	.fixed-height {
		height: calc(100vh - 59px - 24px - 24px);	/* Navbar height - top margin - bottom margin */
	}
</style>