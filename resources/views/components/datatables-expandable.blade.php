<style>
	td.details-control {
		background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
		cursor: pointer;
	}
tr.shown td.details-control {
		background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
	}
</style>

<div class="col-md-12">
	
	<table class="table table-hover table-bordered table-sm dt-responsive wrap" id="datatable"
	style="width:100%">
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
</div>

@push('scripts')
<script type="text/javascript">

	function format (d) {
		console.log(d);
		return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
			'<tr>'+
				'<td>Jam:</td>'+
				'<td>'+d.jam+'</td>'+
			'</tr>'+
			'<tr>'+
				'<td>Tempat:</td>'+
				'<td>'+d.tempat+'</td>'+
			'</tr>'+
		'</table>';
	}

	$(document).ready(function () {
		let table = $('#datatable').DataTable({
			"responsive": true,
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
					@foreach($filters as $filter)
						{{ 'd.'. $filter }} = $('#input-{{ $filter }}').val()
					@endforeach
				}
			},
			"columns": [
				{
					"className":      'details-control pl-5',
					"orderable":      false,
					"data":           'DT_RowIndex',
					"defaultContent": ''
				},
				@foreach($columns as $column=>$title)
					{ "data": "{{$column}}" },
				@endforeach
			],
		});

		$('#datatable tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = table.row( tr );
			if ( row.child.isShown() ) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
			}
			else {
				// Open this row
				row.child( format(row.data()) ).show();
				tr.addClass('shown');
			}
		} );
	});
</script>
@endpush