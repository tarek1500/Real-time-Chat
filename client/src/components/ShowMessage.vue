<template>
	<div>
		<h2 class="h1 title">{{ message.title }}</h2>
		<p class="message">{{ message.message }}</p>
		<h4 class="sender">Sender: <span>{{ message.sender.name }}</span></h4>
		<h4 class="receiver">Receiver: <span>{{ message.receiver.name }}</span></h4>
		<span class="time">{{ message.created_at_string }}</span>
	</div>
</template>

<script>
	export default {
		props: ['message']
	}
</script>

<style scoped>
	.title {
		margin: 0;
	}
	.title::after {
		margin: 1rem 0;
		display: block;
		border-top: 1px solid rgba(0, 0, 0, 0.25);
		content: '';
	}

	.message {
		font-size: 1.5rem;
	}

	.sender span,
	.receiver span,
	.time {
		font-size: 1rem;
	}

	.time {
		font-weight: 500;
	}
</style>