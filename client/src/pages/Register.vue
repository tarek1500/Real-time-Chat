<template>
	<card>
		<template slot="header-title">New here? Create an account...</template>
		<template slot="body-inputs">
			<div class="form-group">
				<input type="text" class="form-control" name="name" placeholder="Full name">
			</div>
			<div class="form-group">
				<input type="email" class="form-control" name="email" placeholder="Email address">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="password" placeholder="Password">
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="password_confirmation" placeholder="Password confirmation">
			</div>
		</template>
		<button slot="submit-button" class="btn btn-primary" @click="register()">Register</button>
	</card>
</template>

<script>
	import Card from '../components/Card.vue'

	export default {
		components: {
			card: Card
		},
		methods: {
			register() {}
		}
	}
</script>

<style>
</style>