@extends('layouts.app')

@section('content')


<div class="modal fade" id="bill-modal" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
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
					<h2>@lang('export')</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="ordertable" class="table table-striped table-bordered jambo_table hoveron padding-table">
						<thead>
							<tr>
								<th rowspan="2" class="vertid">#</th>
								<th colspan="6">@lang('detail')</th>
							</tr>
							<tr>
								<th>@lang('product')</th>
								<th>@lang('qty')</th>
								<th>@lang('customer')</th>
								<th>@lang('date')</th>
								<th>@lang('status')</th>
								<th class="text-center" style="min-width: 30%">
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

	let sstr = new SQLStr();
	let datatable 	= null;

	$(document).ready(function(){


		sstrConfig();

		updateDataTable();

		$(document).on('click', '.bill-download',function(){
			let code = $(this).attr('code');
			$.ajax({
				url: apiURL('bill:get',code),
				type: 'GET',
				data:{
					type: 'account',
					lang : '{{ App::getLocale() }}'
				},
				dataType: 'json',
			}).done((res) => {
				let str = '';
				$(res).each(function(key, value){
					str += `<a class="btn btn-link" href="bill/${value['filepath']}/download">${value['filename']}</a><br>`;
					$('#bill-modal .modal-body').empty();
					$('#bill-modal .modal-body').append(str);
					$('#bill-modal').modal('show');
				});
			}).fail((xhr, status, error) => {
				console.log(status);
			})
		});





	});


	sstrConfig = once(() => {
		sstr.config = {
			primaryTable : "exports as ex",
			select : [
			'MAX(ex.created_at) created_at',
			'MAX(ex.updated_at) updated_at',
			` GROUP_CONCAT(DISTINCT DATE(ex.created_at)) as date `,
			`GROUP_CONCAT(CONCAT('#',p.code,' ','&emsp;',p.name, ' &bull; ', coalesce(o.product_color,'*'), '<br>') 
			SEPARATOR ' ') as product`,
			` GROUP_CONCAT(CONCAT(TRIM(o.qtyp)+0,'<br>') SEPARATOR ' ') as qtyp `,
			` GROUP_CONCAT(DISTINCT CONCAT(c.first_name, ' ', c.last_name)) as customer `,
			` GROUP_CONCAT(DISTINCT o.customer_id) as customer_id `,
			` GROUP_CONCAT(DISTINCT ex.complete) as complete `,
			` CASE WHEN GROUP_CONCAT(DISTINCT ex.complete) = 'no' 
			THEN '<span class="text-success" >รายการใหม่</span>'
			ELSE '<span class="text-primary" >ทำรายการแล้ว</span>'
			END as status `,
			` GROUP_CONCAT(DISTINCT ex.complete) as statusval `,
			` o.code_id ` ],
			join : [
			['INNER JOIN', 	'orders as o'		, 'ex.order_id'	,'o.id'],
			['INNER JOIN', 	'customers as c'	, 'c.id'		,'o.customer_id'],
			['INNER JOIN', 	'products as p'		, 'p.id'		,'o.product_id']
			],
			groupby : ['o.code_id'],
		}
	});

	var updateDataTable = () => {
		(datatable === null ) ? {} : datatable.destroy();
		datatable = $('#ordertable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url : apiURL('dt:export'),
				data : { sqlString : sstr.sqlString }
			},
			columns : [
			{ data : 'DT_Row_Index', name : 'DT_Row_Index', class : 'text-center' },
			{ data : 'product', name : 'product'},
			{ data : 'qtyp' , name : 'qtyp', orderable : false, class : 'text-center'},
			{ data : 'customer', name : 'customer'},
			{ data : 'created_at', name : 'created_at' , type : 'date'},
			{ data : 'status', name : 'status', class : 'text-center' },
			{ data : 'action', name : 'action',class : 'text-center', orderable : false, searchable : false } 
			]
		});
	}
</script>
@endsection