@extends('layouts.app')

@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_title">
					<h2>@lang('product return')</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<button class="btn btn-success input-sm" onclick="location.href = '{{ route('returns.create') }}'">
								<i class="fa fa-paper-plane"></i> 
								@lang('new record')
							</button>
						</li>
						<li>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="table" class="table table-striped table-bordered jambo_table full-width hoveron">
						<thead>
							<tr>
								<th style="width: 15%" rowspan="2">
									#@lang('order number')
								</th>
								<th colspan="4">@lang('detail')</th>
							</tr>
							<tr>
								<th>@lang('product code') / @lang('product color') @lang('product name')</th>
								<th>@lang('qty :param',['param' => __('return')])</th>
								<th>@lang('detail')</th>
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

		$('#table').DataTable({
			processing: true,
			serverSide: true,
			order:[[4,"DESC"]],
			ajax: apiURL('dt:return'),
			columns: [
			{ data: 'order_code', name: 'order_code' },
			{ data: 'product', name: 'product' },
			{ data: 'qtyp', name: 'qtyp' },
			{ data: 'detail', name: 'detail', orderable : false },
			{ data: 'updated_at', name: 'updated_at', orderable : false}
			]
		});
	});

</script>
@endsection