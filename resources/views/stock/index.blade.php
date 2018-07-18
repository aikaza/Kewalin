@extends('layouts.app')

@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_title">
					<h2>@lang('stock') </h2>
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<button class="btn btn-success input-sm" onclick="window.location.href = '{{ route('stocks.create') }}'">
								<i class="fa fa-level-down"></i>
								@lang('import product')
							</button>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="s-table" class="table table-striped table-bordered jambo_table custom-table full-width hoveron">
						<thead>
							<tr>
								<th rowspan="2">#@lang('product code')</th>
								<th colspan="6">@lang('detail')</th>
							</tr>
							<tr>
								<th>@lang('product name')</th>
								<th>@lang('remain')</th>
								<th>@lang('in stock')</th>
								<th width="20%">@lang('image')</th>
								<th>@lang('status')</th>
								<th>@lang('action')</th>
								<th>date</th>
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
		<label>สถานะของสินค้า</label>
		<div>
			<input type="checkbox" name="status" value="normal"> ปกติ
			<input type="checkbox" name="status" value="critical"> ใกล้หมด
			<input type="checkbox" name="status" value="runout"> ไม่มีสินค้า
			<input type="checkbox" name="outdate"> ค้างสต็อก
		</div>
	</div>
	<hr>
	<div>
		<label>สินค้าคงเหลือ 
			[<span id="stock-remain-range-text">
				0 , 100
			</span>]
		</label>
		<div id="slider-stock-remain-range" style="display: block;"></div>
	</div>
	<hr>
	<div>
		<label>หมายเลขสินค้า
			[<span id="stock-id-range-text">
				0 , 100
			</span>]
		</label>
		<div id="slider-stock-id-range" style="display: block;"></div>
	</div>
	<hr>
	<div>
		<label>สินค้าที่อยู่ในสต็อก</label>
		<input type="text" name="" class="form-control" placeholder="ใส่หมายเลขสต็อก" id="stock-check">
	</div>
	<hr>
	<div>
		<label>รูปภาพ</label>
		<div>
			<input id="sch_image1" type="radio" name="sch_image" class="sch-default" checked> ทั้งหมด<br>
			<input id="sch_image2" type="radio" name="sch_image" 
			colname="i.product_id" cond="is not" val="null"> มีรูปภาพ <br>
			<input id="sch_image3" type="radio" name="sch_image" 
			colname="i.product_id" cond="is" val="null"> ไม่มีรูปภาพ
		</div>
	</div>
	<hr>

</div>


@endsection

@section('sc')
<script type="text/javascript">
	// declare var
	let datatable 	= null;
	let sstr 		= new SQLStr();


	$(document).ready(() => {


		// do once
		sstrConfig();

		checkStatus = () => {
			let str = [];
			$.each($('input[type=checkbox][name=status]'), (key,inst) => {
				let val = $(inst).val();
				let checked = $(inst).prop('checked');
				if(checked){
					str.push(val);
				}
			});
			sstr.deleteHaving('status');
			if(str.length !== 0){
				str = str.map(n => {
					if(n === 'normal'){
						return `COALESCE(SUM(s.qtyp),0) > (SELECT cast(c.value as UNSIGNED) FROM 
						configurations c where c.key='cripoint')`;
					}
					else if(n === 'runout'){
						return `COALESCE(SUM(s.qtyp),0) = 0`;
					}
					else{
						return `COALESCE(SUM(s.qtyp),0) BETWEEN 1 AND (SELECT cast(c.value as UNSIGNED) FROM 
						configurations c where c.key='cripoint')`;
					}
				});
				sqlString = str.join(' OR ');
				sqlString = `( ${sqlString} )`;
				sstr.addHaving('status',sqlString);
			}
			updateDataTable();
		}

		outdateProducts = () => {
			let outdate_condition = "<?php echo appconfig('outdatedr'); ?>";
			sstr.deleteCondition('outdate');
			if($('input[type=checkbox][name=outdate]').prop('checked')){
				sstr.addCondition('outdate','TO_DAYS(s.created_at)',' <=',
					`TO_DAYS(NOW()) - ${outdate_condition}`);
			}
			updateDataTable();
		}


		updateDataTable();

		$('input[type=checkbox][name=status]').on('click', ()=>{
			checkStatus();
		});

		initSearch();

		$('input[type=checkbox][name=outdate]').on('click', () => {
			outdateProducts();
		});

		// event
		$('input[type=radio][name=sch_image]').on('change',function(){
			let all_inputs = $('input[type=radio][name=sch_image]');
			$.each(all_inputs, (key, input) => {
				sstr.deleteCondition($(input).attr('id'));
			});
			sstr.addConditionByProp(this);
			updateDataTable();
		});

		$('input[type=checkbox][name=pfilter]').on('click', function(){
			if($(this).prop('checked')){
				sstr.deleteCondition($(this).attr('id'));
				sstr.addConditionRaw($(this).attr('id'),)
			}
		});

		$( function() {
			$('#stock-remain-range-text').html(`{{$min_pd_remain}} , {{$max_pd_remain}}`);
			$( "#slider-stock-remain-range" ).slider({
				range: true,
				min: {{$min_pd_remain}},
				max: {{$max_pd_remain}},
				values: [ {{$min_pd_remain}}, {{$max_pd_remain}} ],
				change: function( event, ui ) {
					sstr.deleteHaving('premain');
					sstr.addSelect('COALESCE(SUM(s.qtyp),0) as qtyp');
					sstr.addGroupBy('p.id');
					sstr.addHaving('premain','qtyp','between',ui.values);
					$('#stock-remain-range-text').html(`${ui.values[0]} , ${ui.values[1]}`);
					updateDataTable();
				}
			});
		} );
		$( function() {
			$('#stock-id-range-text').html(`{{ $min_pd_id }} , {{ $max_pd_id }}`);
			$( "#slider-stock-id-range" ).slider({
				range: true,
				min: {{ $min_pd_id }},
				max: {{ $max_pd_id }},
				values: [ {{ $min_pd_id }}, {{ $max_pd_id }} ],
				change: function( event, ui ) {
					sstr.deleteCondition('minmaxid');
					sstr.addCondition('minmaxid','p.id','between',ui.values);
					updateDataTable();
					$('#stock-id-range-text').html(`${ui.values[0]} , ${ui.values[1]}`);
				}
			});
		} );

		$('#stock-check').keyup((e)=>{
			if($('#stock-check').val() !== ''){
				let stock_ids = $('#stock-check').val().split(/\s+/).filter((val) => val);
				let str = stock_ids.map( (n) => {
					return 's.lot_number = ' + n;
				}).join(' OR ');

				str = '( (' + str + ') AND s.qtyp > 0)';
				sstr.deleteCondition('stockcheck');
				sstr.addConditionRaw('stockcheck',str);
				updateDataTable();
			}
			else{
				sstr.deleteCondition('stockcheck');
				updateDataTable();
			}
		});

	});

	initSearch = once( () => {
		let cri_products = "<?php echo $show_cri_products; ?>";
		let remain_products = "<?php echo $show_remain_products; ?>";
		let outdate_products = "<?php echo $show_outdate_products; ?>";
		if(cri_products === 'true'){
			$('input[type=checkbox][name=status][value=critical]').prop('checked',true);
			$('input[type=checkbox][name=status][value=runout]').prop('checked',true);
			checkStatus();
		}
		if(remain_products === 'true'){
			$('input[type=checkbox][name=status][value=critical]').prop('checked',true);
			$('input[type=checkbox][name=status][value=normal]').prop('checked',true);
			checkStatus();
		}
		if(outdate_products === 'true'){
			$('input[type=checkbox][name=outdate]').prop('checked',true);
			outdateProducts();
		}
	});


	sstrConfig = once(() => {
		sstr.config = {
			primaryTable : "products as p",
			select : [
			'p.id as p_id','p.code as p_code','p.name as p_name',
			'COALESCE(SUM(s.qtyp),0) as qtyp',
			'MAX(s.updated_at) updated',
			`CASE WHEN GROUP_CONCAT(i.path) IS null THEN 'ไม่มี' 
			ELSE GROUP_CONCAT(DISTINCT i.path) END as p_image`,
			`CASE WHEN GROUP_CONCAT(s.lot_number) IS null THEN 'ไม่มีสต็อก' 
			ELSE GROUP_CONCAT(DISTINCT CONCAT('<a data-toggle="tooltip" data-placement="top" title="', '<p><strong>หมายเลขสต็อก</strong> : ',s.lot_number,'</p>','<p><strong>บันทึกข้อความ</strong> : ',COALESCE(s.note,"ไม่มีบันทึกข้อความ"),'</p>">','<code>',s.lot_number,'</code>','</a>') SEPARATOR ' ') 
			END as p_lotnumber`,
			`CASE WHEN COALESCE(SUM(s.qtyp),0) > (SELECT cast(c.value as UNSIGNED) from configurations c where c.key='cripoint') THEN '<span class="text-success">ปกติ</span>'
			WHEN COALESCE(SUM(s.qtyp),0) = 0 THEN '<span class="text-danger">ไม่มีสินค้า</span>'
			ELSE '<span class="text-warning">สินค้าใกล้หมด</span>' END as p_status`
			],
			join : [
			['LEFT JOIN', 'images as i', 'p.id','i.product_id'],
			['LEFT JOIN', '(SELECT lot_number,id,qtyp,product_id,created_at,updated_at,note FROM stocks WHERE qtyp > 0) as s', 'p.id','s.product_id'],
			],
			groupby : ['p.id'],
			orderby : ['updated DESC']
		}
	});

	var updateDataTable = () => {
		console.log(sstr.sqlString);
		(datatable === null) ? {} :  datatable.destroy();
		datatable = $('#s-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url : apiURL('dt:stock'),
				data : { sqlString : sstr.sqlString }
			},
			columns: [
			{ data : 'p_code', name : 'p_code'},
			{ data : 'p_name', name : 'p_name'},
			{ data : 'qtyp', name : 'qtyp'},
			{ data : 'p_lotnumber', name : 'p_lotnumber'},
			{ data : 'p_image', name : 'p_image', searchable : false, orderable : false},
			{ data : 'p_status', name : 'p_status'},
			{ data : 'action', name : 'action' , searchable : false, orderable : false, 
				className : 'text-center'},
			{ data : 'updated', name : 'updated'}
			],
			columnDefs: [
			{
				"targets": [ 7 ],
				"visible": false,
				"searchable": false,
				"type": "date"
			}],
			order: [[ 7, "desc" ]]
		});
	}


</script>
@endsection