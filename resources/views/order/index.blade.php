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
					<h2>@lang('order')</h2>
					@if (canAccess('rsb'))
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<button class="btn btn-success input-sm" onclick="window.location.href = '{{ route('orders.create') }}'">
								<i class="fa fa-plus"></i> @lang('new record')
							</button>
						</li>
					</ul>
					@endif
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


@section('search-ctn')
<div class="search-ctn" id="stock-search-ctn" style="display: none;">
	<div>
		<i class="fa fa-times-circle fa-2x close-search" style="float:right;cursor: pointer;"></i>
	</div>
	<h4 style="border-bottom: 2px solid white;color: white;padding-bottom: 8px;margin-bottom: 32px;" class="text-center">กรองข้อมูล</h4>
	<div>
		<label>จำนวนสั่งซื้อ (ม้วน) : 
			<span id="qtyp-text">
				{{ $min_qtyp }} - {{ $max_qtyp }}
			</span>
		</label>
		<div id="qtyp-range"></div>
	</div>
	<hr>
	<div>
		<label>ชื่อลูกค้า</label>
		<input type="text" id="ct-filter" placeholder="ระบุชื่อลูกค้า" class="form-control">
	</div>
	<hr>
	<div>
		<label>สถานะการสั่งซื้อ</label>
		<div>
			<input type="checkbox" name="status" value="prepare"> รายการใหม่ <br>
			<input type="checkbox" name="status" value="success"> จัดส่งแล้ว <br>
			<input type="checkbox" name="status" value="cancel"> ยกเลิกรายการ <br>
		</div>
	</div>
	<hr>
</div>

@endsection

@section('sc')
<script type="text/javascript">

	let sstr = new SQLStr();
	let datatable 	= null;

	$(document).ready(function(){

		$(document).on('click','.cancel-btn', function(){
			return confirm('ยืนยันการทำรายการ?');
		});


		$(document).on('click', '.bill-download',function(){
			let code = $(this).attr('code');
			$.ajax({
				url: apiURL('bill:get',code),
				type: 'GET',
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



		sstrConfig();


		updateDataTable();

		checkStatus  = () => {
			let str = [];
			$.each($('input:checkbox[name=status]'), (key,inst) => {
				let val = $(inst).val();
				let checked = $(inst).prop('checked');
				if(checked){
					str.push(val);
				}
			});
			sstr.deleteHaving('status');
			if(str.length !== 0){
				str = str.map(n => `GROUP_CONCAT(DISTINCT o.status) = '${n}'`);
				sqlString = str.join(' OR ');
				sqlString = `( ${sqlString} )`;
				sstr.addHaving('status',sqlString);
			}
			updateDataTable();
		}

		initSearch();


		$('input:checkbox[name=status]').on('click', () => {
			checkStatus();
		});


		$( function() {
			$( "#qtyp-range" ).slider({
				range: true,
				min: {{ $min_qtyp }},
				max: {{ $max_qtyp }},
				values: [ {{ $min_qtyp }}, {{ $max_qtyp }} ],
				change: function( event, ui ) {
					sstr.deleteHaving('minmaxqtyp');
					sstr.addHaving('minmaxqtyp','SUM(o.qtyp)','between',ui.values);
					updateDataTable();
					$('#qtyp-text').html(`${ui.values[0]} , ${ui.values[1]}`);
				}
			});
		} );

		$('#ct-filter').keyup(function(){
			let value = $(this).val().trim();
			value = value.replace(/[!@#$%^&*]/g, "");
			sstr.deleteCondition('customer');
			if(value !== ''){
				sstr.addConditionRaw('customer',
					`CONCAT(c.first_name,' ',c.last_name) LIKE '%${value}%'`);
			}
			updateDataTable();
		});



	});

	initSearch = once( () => {
		let new_orders = "<?php echo $show_new_order; ?>";
		if(new_orders === 'true'){
			$('input[type=checkbox][name=status][value=prepare]').prop('checked',true);
			checkStatus();
		}
	});


	sstrConfig = once(() => {
		sstr.config = {
			primaryTable : "orders as o",
			select : [
			'MAX(o.created_at) created_at',
			'MAX(o.updated_at) updated_at',
			'GROUP_CONCAT(DISTINCT DATE(o.created_at)) as date',
			`GROUP_CONCAT(CONCAT('#',p.code,' ','&emsp;',p.name, ' &bull; ', coalesce(o.product_color,'*'), '<br>') 
			SEPARATOR ' ') as product`,
			`GROUP_CONCAT(CONCAT(TRIM(o.qtyp)+0,'<br>') SEPARATOR ' ') as qtyp`,
			`GROUP_CONCAT(DISTINCT CONCAT(c.first_name, ' ', c.last_name)) as customer`,
			`GROUP_CONCAT(DISTINCT o.customer_id) as customer_id`,
			`CASE
			WHEN GROUP_CONCAT(DISTINCT o.status) = 'prepare' 
			THEN '<span class="text-success" >รายการใหม่</span>'
			WHEN GROUP_CONCAT(DISTINCT o.status) = 'success' THEN 
			'<span class="text-primary" >จัดส่งแล้ว</span>'
			ELSE '<span class="text-danger" >ยกเลิก</span>'
			END as status`,
			`GROUP_CONCAT(DISTINCT o.status) as statusval`,
			'o.code_id',
			'GROUP_CONCAT(DISTINCT o.created_for) as created_for'
			],
			join : [
			['INNER JOIN', 'products as p', 'p.id','o.product_id'],
			['INNER JOIN', 'customers as c', 'c.id','o.customer_id'],
			],
			groupby : ['o.code_id'],
			having : [['create_for_id','created_for','=', `'{{$created_for}}'`]]
		}
		let created_for = "{{$created_for}}";
		if(created_for === 'admin' || created_for === 'rsb') {
			sstr.deleteHaving('create_for_id');
		}
	});

	var updateDataTable = () => {
		(datatable === null ) ? {} : datatable.destroy();
		datatable = $('#ordertable').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url : apiURL('dt:order'),
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