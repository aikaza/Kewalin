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
                                @lang('make bill')
                                <small>
                                    {{ $customer->first_name }}
									{{ $customer->last_name }}
                                </small>
                            </li>
                        </ul>
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <select class="form-control input-sm" id="filter">
                                <option value="all">
                                    ทั้งหมด
                                </option>
                                <option selected="" value="new">
                                    รายการใหม่
                                </option>
                            </select>
                        </li>
                    </ul>
                    <div class="clearfix">
                    </div>
                </div>
                <div class="x_content">
                    <form action="{{ route('debtbill.make',$customer->id) }}" id="form" method="POST">
                        {{ csrf_field() }}
                    </form>
                    <table class="table table-striped table-bordered jambo_table" id="table">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    #
                                </th>
                                <th>
                                    @lang('export number')
                                </th>
                                <th>
                                    @lang('export date')
                                </th>
                                <th>
                                    @lang('qty :param',['param' => __('roll')])
                                </th>
                                <th>
                                    @lang('qty :param',['param' => __('2ry')])
                                </th>
                                <th>
                                    @lang('total')
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <button class="btn btn-success" form="form" type="submit" id="submit-btn" style="display: none">
                        @lang('make bill')
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection



@section('sc')
<script type="text/javascript">
    let type = 'new';
	let datatable = null;
    $(document).ready(function(){

		let checked = 0;


		$('#filter').on('change', function(){
			type = $(this).val();
			updateDataTable();
		});

		updateDataTable();

		$(document).on('change', '.checkbox', function(){
			if(this.checked){
				if(checked < 9){
					checked++;
				}
				else{
					alert('ทำรายการสูงสุดแล้ว');
					$(this).prop('checked',false);
				}
			}
			else{
				checked--;
			}
		});
	});
	var updateDataTable = () => {
		(datatable === null ) ? {} : datatable.destroy();
		datatable = $('#table').DataTable({
			processing : true,
			serverSide : true,
			ajax : {
				url : apiURL('dt:exportbill:list',{{ $customer->id }}),
				type : 'GET',
				data : {
					type : type
				}
			},
			columns : [
			{ data : 'index', name : 'index', class : 'text-center' },
			{ data : 'code', name : 'code'},
			{ data : 'date', name : 'date'},
			{ data : 'qtyp' , name : 'qtyp'},
			{ data : 'qtys', name : 'qtys'},
			{ data : 'total', name : 'total'}
			],
			createdRow : function(row, data, index){
				if(data['date'] === getDate()){
					$(row).addClass('success');
				}
			},
			order : [[2,'desc']],
			fnDrawCallback: function () {
				if( this.fnSettings().fnRecordsTotal() > 0){
					$('#submit-btn').show();
				}else{
					$('#submit-btn').hide();
				}
			}
		});

		 
	}
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
</script>
@endsection
