
<table class="table table-hover table-bordered table-sm" id="datatable">
	<thead>
		<tr class="font-weight-bold">
			<th style="width: 1%">#</th>
			@foreach($columns as $column=>$th)
				{!! $th !!}
			@endforeach
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
@push('scripts')
<script type="text/javascript">
	$(document).ready(function () {
		let table = $('#datatable').DataTable({
			"pageLength": 10,
			"processing": true,
			"serverSide": true,
			"orderable": true,
			"ajax":{
				"url": "{{ $url }}",
				"dataType": "json",
				"type": "POST",
				"data":function(d) {
					d._token = "{{csrf_token()}}"
				}
			},
			"columns": [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				@foreach($columns as $column=>$title)
					{ "data": "{{$column}}" },
				@endforeach
			],
		});
	});
</script>
@endpush