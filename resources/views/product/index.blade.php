@extends('layouts.app')

@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_title">
					<h2>@lang('product')</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<button class="btn btn-success input-sm" onclick="location.href = '{{ route('products.create') }}'">
								<i class="fa fa-plus"></i> @lang('new record')
							</button>
						</li>
						<li>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="p-table" class="table table-striped table-bordered jambo_table full-width hoveron">
						<thead>
							<tr>
								<th style="width: 15%" rowspan="2">
									#@lang('product code')
								</th>
								<th colspan="4">@lang('detail')</th>
							</tr>
							<tr>
								<th>@lang('product name')</th>
								<th style="width: 20%">@lang('image')</th>
								<th style="width: 20%">@lang('action')</th>
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

		$('#p-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: apiURL('dt:product'),
			columns: [
			{ data: 'code', name: 'code' },
			{ data: 'name', name: 'name' },
			{ data: 'image', name: 'image'  ,searchable: false, orderable : false},
			{ data: 'action', name: 'action', className: 'text-center', searchable: false, orderable : false
		}
		]
	});
	});

</script>
@endsection