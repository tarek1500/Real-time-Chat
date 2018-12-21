<template>
	<flash-message transitionName="flash" outerClass="flash-container"></flash-message>
</template>

<script>
	export default {}
</script>

<style>
	.flash-container {
		position: fixed;
		top: 20px;
		left: 15px;
		right: 15px;
		z-index: 1070;
	}

	.flash-container .flash__message {
		margin-bottom: 0;
		border-radius: 10px;
		box-shadow: 0 0 1.85rem rgba(0, 0, 0, 0.4);
	}
	.flash-container .flash__message + .flash__message {
		margin-top: 22px;
	}

	.flash-container .flash__message h5 {
		margin: 0;
		text-align: center;
	}

	.flash-container .flash__message ul {
		margin: 0;
	}

	.flash-container .flash__message ul li span {
		font-weight: bold;
		text-transform: capitalize;
	}

	.flash-enter-active {
		animation: slide 0.4s linear;
	}

	.flash-leave-active {
		animation: close 0.2s linear;
	}

	@keyframes slide {
		0% {
			top: 30vh;
			opacity: 0;
		}
		75% {
			top: -20px;
		}
		100% {
			top: 0;
			opacity: 1;
		}
	}

	@keyframes close {
		0% {
			opacity: 1;
			top: 0;
		}
		100% {
			opacity: 0;
			top: -20px;
		}
	}
</style>