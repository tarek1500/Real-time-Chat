<template>
	<div class="card w-50 mx-auto text-center">
		<div class="card-header"><slot name="header-title"></slot></div>
		<div class="card-body">
			<slot name="body-inputs"></slot>
			<slot name="submit-button"></slot>
		</div>
	</div>
</template>

<script>
	export default {}
</script>

<style>
	@media (max-width: 767.98px) {
		.card {
			width: 100% !important;
		}
	}
</style>