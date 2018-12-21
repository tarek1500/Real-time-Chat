<template>
	<div class="container-fluid">
		<navbar></navbar>
		<flash></flash>
		<router-view></router-view>
	</div>
</template>

<script>
	import Navbar from './components/Navbar.vue'
	import FlashMessage from './components/FlashMessage.vue'

	export default {
		components: {
			navbar: Navbar,
			flash: FlashMessage
		}
	}
</script>

<style>
</style>