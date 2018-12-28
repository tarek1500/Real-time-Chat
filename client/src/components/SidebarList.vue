<template>
		<button type="button" class="list-group-item list-group-item-action" @click="changeActive">
			<slot name="list-item"></slot>
		</button>
</template>

<script>
	export default {
		methods: {
			changeActive (e) {
				var active_element = e.target.parentElement.querySelector('button.active')

				if (active_element)
					active_element.classList.remove('active')

				e.target.classList.add('active')
			}
		}
	}
</script>

<style scoped>
	button {
		cursor: pointer;
		transition: all 0.2s linear;
	}
</style>