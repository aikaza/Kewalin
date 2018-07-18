@extends('layouts.app')

@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_title">
					<h2 style="line-height: 25px !important;">
						@lang('customer')
					</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<button class="btn btn-success input-sm" onclick="location.href='{{ route('customers.create') }}'">
								<i class="fa fa-plus"></i> 
								@lang('new record')
							</button>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="c-table" class="table table-striped table-bordered jambo_table full-width hoveron">
						<thead>
							<tr>
								<th width="10%">#@lang('customer id')</th>
								<th>@lang('name')</th>
								<th>@lang('alias name')</th>
								<th>@lang('phone number')</th>
								<th>@lang('email')</th>
								<th>@lang('address')</th>
								<th width="20%" class="text-center">
									@lang('action')
								</th>
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

		$('#c-table').DataTable({
			processing : true,
			serverSide : true,
			ajax : apiURL('dt:customer'),
			columns : [
			{ data : 'id', name : 'id'},
			{ data : 'name', name : 'name'},
			{ data : 'alias_name', name : 'alias_name'},
			{ data : 'phone_no', name : 'phone_no'},
			{ data : 'email', name : 'email'},
			{ data : 'address', name : 'address'},
			{ data: 'action', name: 'action', className: 'text-center', searchable: false, orderable : false 
			} ]
		});
	});
</script>

@endsection