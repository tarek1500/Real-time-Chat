<template>
	<card>
		<template slot="header-title">Login to your account...</template>
		<template slot="body-inputs">
			<div class="form-group">
				<input type="email" class="form-control" placeholder="Enter email">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" placeholder="Password">
			</div>
		</template>
		<button slot="submit-button" class="btn btn-primary" @click="login()">Login</button>
	</card>
</template>

<script>
	import Card from '../components/Card.vue'

	export default {
		components: {
			card: Card
		},
		methods: {
			login() {}
		}
	}
</script>

<style>
</style>