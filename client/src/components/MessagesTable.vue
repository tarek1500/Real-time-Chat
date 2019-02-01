<template>
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover mb-0">
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
	tbody tr {
		cursor: pointer;
	}
	tbody tr.new {
		font-weight: bold;
	}
</style>