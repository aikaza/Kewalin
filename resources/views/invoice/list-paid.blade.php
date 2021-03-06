@extends('layouts.app')

@section('content')
<style type="text/css">
input[type='checkbox'] {
	width:18px;
	height:18px;
}
</style>
<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_title">
					<h2>
						<ul class="breadcrumb" style="padding: 0;background-color: transparent;margin: 0">
							<li>
								<a href="{{ route('invoices.index') }}">
									@lang('debt')
								</a>
							</li>
							<li class="active">
								@lang('list paid')
								<small>
									{{ $customer->first_name }}
									{{ $customer->last_name }}
								</small>
							</li>
						</ul>
					</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="table" class="table table-striped table-bordered jambo_table">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th>@lang('bill number')</th>
								<th>@lang('total')</th>
								<th>@lang('bank')</th>
								<th>@lang('cheque number')</th>
								<th>@lang('issue date')</th>
								<th>@lang('note')</th>
							</tr>
						</thead>
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

		function getDate(){
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; 
			var yyyy = today.getFullYear();
			if(dd<10) {
				dd = '0'+dd
			} 
			if(mm<10) {
				mm = '0'+mm
			} 

			today = yyyy + '-' + mm + '-' + dd;
			return today;
		}

		$('#table').DataTable({
			processing : true,
			serverSide : true,
			ajax : apiURL('dt:bill:paid:list',{{ $customer->id }}),
			columns : [
			{ data : 'DT_Row_Index', name : 'DT_Row_Index', class : 'text-center' },
			{ data : 'bill_number', name : 'bill_number'},
			{ data : 'total_debt' , name : 'total_debt'},
			{ data : 'bank', name : 'bank'},
			{ data : 'cheque_number', name : 'cheque_number'},
			{ data : 'issue_date', name : 'issue_date'},
			{ data : 'note', name : 'note'}
			],
			createdRow : function(row, data, index){
				if(data['date'] === getDate()){
					$(row).addClass('success');
				}
			}
		});

	});
</script>
@endsection