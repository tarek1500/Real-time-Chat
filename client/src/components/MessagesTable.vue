<template>
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover">
			<thead>
				<tr>
					<th><slot name="sender-type"></slot></th>
					<th>Subject</th>
					<th>Time</th>
				</tr>
			</thead>
			<tbody>
				<slot name="message"></slot>
			</tbody>
		</table>
	</div>
</template>

<script>
	export default {}
</script>

<style scoped>
	table tbody tr {
		cursor: pointer;
	}
	table tbody tr.new {
		font-weight: bold;
	}

	table tbody tr:not(.new) > th:first-of-type {
		font-weight: initial;
	}
</style>