<template>
	<messages-table>
		<template slot="sender-type">To</template>
		<tr slot="message" @click="showMessage()">
			<th>User 2</th>
			<td>Subject</td>
			<td>4 minutes ago.</td>
		</tr>
	</messages-table>
</template>

<script>
	import MessagesTable from './MessagesTable.vue'

	export default {
		components: {
			'messages-table': MessagesTable
		},
		methods: {
			showMessage (id) {}
		},
		created () {}
	}
</script>

<style>
</style>