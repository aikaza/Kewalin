@extends('layouts.app')

@section('content')

<div class="modal fade" id="status-update-modal" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<form method="POST" action="#">
					{{ csrf_field() }}
					{{ method_field('put') }}
					<input type="radio" name="status" id="status1">
					<label for="status1">ชำระแล้ว</label>
					<input type="radio" name="status" id="status2">
					<label for="status2">ยังไม่ได้ชำระ</label>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_title">
					<h2>
						@lang('debt')
					</h2>
					<ul class="nav navbar-right panel_toolbox">
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="invoicetable" class="table table-striped table-bordered jambo_table">
						<thead>
							<tr>
								<th width="5%">#</th>
								<th>@lang('customer')</th>
								<th>@lang('total debt')</th>
								<th>@lang('action')</th>
								<th>@lang('date')</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
@endsection



@section('sc')
<script type="text/javascript">
	$(document).ready(function(){

		$('#invoicetable').DataTable({
			processing : true,
			serverSide : true,
			ajax : apiURL('dt:invoice'),
			columns : [
			{ data : 'DT_Row_Index', name : 'DT_Row_Index', class : 'text-center' },
			{ data : 'customer', name : 'customer', class : 'text-center'},
			{ data : 'total' , name : 'total' , class : 'text-center'},
			{ data : 'action', name : 'action', class : 'text-center'},
			{ data : 'date', name : 'date'}
			],
			columnDefs: [
			{
				"targets": [ 4 ],
				"visible": false,
				"searchable": false
			}],
			order: [[ 4, "desc" ]]
		});

	});
</script>
@endsection