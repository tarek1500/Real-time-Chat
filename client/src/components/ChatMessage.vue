<template>
	<div class="message">
		<h3 class="message-from">
			<slot name="message-from"></slot>
			<span class="message-time">
				<slot name="message-time"></slot>
			</span>
		</h3>
		<p class="message-body">
			<slot name="message-body"></slot>
		</p>
	</div>
</template>

<script>
	export default {}
</script>

<style scoped>
	.message {
		width: 90%;
		padding: 15px;
		border-radius: 0.25rem;
	}
	.message.float-left {
		background-color: wheat;
	}
	.message.float-right {
		background-color: #dfe9fe;
	}
	.message + .message {
		margin-top: 5px;
	}

	.message .message-time {
		position: relative;
		bottom: -8px;
		padding-left: 5px;
		font-size: 0.75rem;
		font-weight: initial;
	}

	.message .message-body {
		margin: 0;
		font-size: 1.25rem;
	}
</style>