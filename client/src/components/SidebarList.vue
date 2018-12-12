<template>
		<button type="button" class="list-group-item list-group-item-action" @click="ChangeActive">
			<slot name="list-item"></slot>
		</button>
</template>

<script>
	export default {
		methods: {
			ChangeActive (e) {
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
	}
</style>