<template>
	<div class="text-center">
		<div class="form-group">
			<multi-select :options="users"></multi-select>
		</div>
		<div class="form-group">
			<textarea class="form-control" rows="5"></textarea>
		</div>
		<button class="btn btn-primary" @click="send">Send</button>
	</div>
</template>

<script>
	import Multiselect from 'vue-multiselect'
	import '../../node_modules/vue-multiselect/dist/vue-multiselect.min.css'

	export default {
		components: {
			'multi-select': Multiselect
		},
		data () {
			return {
				users: []
			}
		},
		methods: {
			send() {}
		},
		created() {}
	}
</script>

<style scoped>
	textarea {
		resize: none;
	}
</style>