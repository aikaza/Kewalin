@extends('layouts.app')

@section('php')
@php
$units = units();
$init_unit = App::isLocale('th') ? $units->first()->name : $units->first()->name_eng;
@endphp
@endsection


@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="x_content">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_title">
						<h2>
							<ul class="breadcrumb" style="padding: 0;background-color: transparent;margin: 0">
								<li>
									<a href="{{ route('stocks.index') }}">
										@lang('stock')
									</a>
								</li>
								<li class="active">
									@lang('import product in lot number') 
									<span style="color: red">
										{{ $lot_no }}
									</span>
									<input type="text" name="note" size="60" class="borderless" style="text-align: left;margin-left: 16px" placeholder="{{ __('insert note')}}" form="add_form">
								</li>
							</ul>
						</h2>
						<div class="clearfix"></div>
					</div>

					<div class="x_content">
						<br />
						<form method="POST" action="{{ route('stocks.store') }}" id="add_form">
							{{ csrf_field() }}
							<input type="hidden" name="lot_no" value="{{ $lot_no }}">
							<input type="hidden" name="uuid" value="{{(string)\Uuid::generate()}}">
						</form>
						<div class="form-group">
							<table class="table table-striped table-bordered input-table jambo_table" id="p-add-table">
								<thead>
									<tr>
										<th rowspan="2" style="vertical-align: middle !important;width: 20%">
											# @lang('product code') 
										</th>
										<th rowspan="2" style="vertical-align: middle !important;width: 10%">
											# @lang('color')
										</th>	
										<th colspan="5">@lang('unit') &ensp;
											@foreach ($units as $i => $unit)
											<label class="clickable">
												<input type="radio" name="unit" value="{{$unit->id}}" form="add_form" {{ ($i === 0) ? 'checked' : '' }}> 
												{{ App::isLocale('th') ? $unit->name : $unit->name_eng }}
											</label>
											@endforeach
										</th>
									</tr>
									<tr>
										<th>@lang('qty :param',['param'=>__('roll')])</th>
										<th id="sunit">
											@lang('qty :param',['param'=> $init_unit])
										</th>
										<th id="price-text">
											@lang('import price/:param',['param' => $init_unit])
										</th>
										<th width="18%" class="text-center" colspan="2">
											@lang('action')
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<input type="text"  name="p_code[]" class="form-control p-code rf show" form="add_form" id="origin" required>
											<span class="txt-p-code rlf hidden"></span>
										</td>
										<td>
											<input type="text" name="p_color[]" class="form-control p-color rf show" form="add_form" required id="p-color">
											<span class="txt-p-color rlf hidden"></span>
										</td>
										<td>
											<input type="text" name="qtyp[]" class="form-control qtyp rf show" form="add_form" min="0" required>
											<span class="txt-qtyp rlf hidden" ></span>
										</td>
										<td>
											<input type="text" name="qtys[]" class="form-control qtys rf show" form="add_form" min="0" required>
											<span class="txt-qtys rlf hidden"></span>
										</td>
										<td>
											<input type="text" name="cst[]" class="form-control cst rf show" form="add_form" min="0" required>
											<span class="txt-cst rlf hidden"></span>
										</td>
										<td style="width: 9%">
											<button class="btn btn-success save-btn btn-block" state="unsaved" style="margin:auto;" type="button" form="add_form">
												<i class="fa fa-save"></i>&ensp;@lang('save')
											</button>
											<td style="width: 9%">
												<button class="btn btn-danger del-btn btn-block" type="button" style="margin:auto;" form="add_form">
													<i class="fa fa-trash"></i>&ensp;@lang('delete')
												</button>
											</td>
										</tr>
									</tbody>
									<tfoot>
										<tr id="sumary">
											<th id="total-list" style="vertical-align: middle;" colspan="2">
												@lang('total n product',['n' => '1'])
											</th>
											<th style="vertical-align: middle;">
												<span id="total-qtyp">0</span>
											</th>
											<th style="vertical-align: middle;">
												<span id="total-qtys">0.00 </span>

											</th>
											<th id="total-cst" style="vertical-align: middle;">
												&#3647; 0.00
											</th>
											<th style="vertical-align: middle;" colspan="2">
												<button class="btn btn-default btn-block" id="add-row" type="button" form="add_form" style="margin: auto;">
													<i class="fa fa-plus-circle"></i> @lang('add row')
												</button>
											</th>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="form-group">
								<button type="button" class="btn btn-success" form="add_form" id="submit-btn">
									<i class="fa fa-check-circle"></i> Submit
								</button>
							</div>
							<!-- </form>  -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /page content -->

	@endsection

	@section('sc')
	<script type="text/javascript">
	//declare global variable
	let data = new Data();
	let add_btn  	= getElmById('add-row');
	let table       = new InputTable('p-add-table');
	let id_check 	= false;
	let table_conf  = table.config = {
		cloneRow : 1,
		text : {
			event : 'rowFixed',
			value : 'last',
			in : 'tfoot'
		}
	}
	data.keep('sunit','y');


	initSuggestion('product',function(res){
		data.keep('p_suggestions',res.suggestions);
	});
	initSuggestion('color',function(res){
		data.keep('clr_suggesrtions',res.suggestions);
	});

	$(document).ready(function(){


		// add row
		table.inst.on('click','#add-row',() => {
			let uuid = uuidv4();
			let uuid2 = uuidv4();
			table.addRow(-1);
			table.row = table.lastRow;
			save_html = table.row.find('button.save-btn').html();
			save_html = save_html.replace(':save',"{{__('save')}}");
			table.row.find('button.save-btn').html(save_html);
			table.row.find('input.p-code').attr('id', uuid);
			table.row.find('input.p-color').attr('id', uuid2);
			$('#'+uuid).autocomplete({
				lookup : data.get('p_suggestions'),
				lookupLimit : 20,
				autoSelectFirst : true
			});
			$('#'+uuid2).autocomplete({
				lookup : data.get('clr_suggesrtions'),
				lookupLimit : 20,
				autoSelectFirst : true
			});
			table.focus();
			updateContent();
		});

		// delete row
		table.inst.on('click','.del-btn', e => {
			if(table.rowCount > 1){
				if (confirm("ยืนยันการลบรายการ?"))
					table.thisRow(e.currentTarget).remove();
			}
			updateContent();
		});

		// calculate cost
		table.inst.on('input', '.cst, .qtyp', e => {
			table.row = table.thisRow(e.currentTarget);
			let cst = (table.valueC('cst').length === 0) ? 0 : table.valueC('cst');
			let qtyp = (table.valueC('qtyp').length === 0) ? 0 : table.valueC('qtyp');
			let total = cst * qtyp;
			table.valueC('total',total);
		});

		// go to new line after enter
		table.inst.on('keyup','input[type=text]', e => {
			table.row = table.thisRow($(e.currentTarget));
			let checkEmpty = true;
			if(e.keyCode === 13) {
				try{
					checkEmpty = focusInputEvent(table.row);
				}
				catch(err){
					throw new Error(err);
				}
				finally{
					if(checkEmpty){
						let res = checkProduct(getProductCode(table.valueC('p-code')));
						if(res){
							table.findC('save-btn').trigger('click');
							add_btn.trigger('click');
						}
						else{
							table.findC('save-btn').trigger('click');
						}
					}
				}
			}
		});

		// submit form
		$('#submit-btn').click(function(){
			table.findC('save-btn').trigger('click');
			$('.p-code').each((key,val) => {
				$(val).val(getProductCode($(val).val()));
			});
			$('#add_form').submit();
		});



		// save 
		table.inst.on('click','.save-btn', e => {
			table.row = table.thisRow(e.currentTarget);
			let res = checkProduct(getProductCode(table.valueC('p-code')));
			if(res){
				if ($(e.currentTarget).attr('state') !== 'saved') {
					let pcode 	= table.valueC('p-code');
					let pcolor 	= table.valueC('p-color');
					let cst 	= (table.valueC('cst').length === 0) ? 0.00 : parseFloat(table.valueC('cst'));
					let qtyp 	= (table.valueC('qtyp').length === 0) ? 0.00 : parseFloat(table.valueC('qtyp'));
					let qtys 	= table.valueC('qtys');
					let cost 	= cst * qtyp;
					table.hideC('rf');
					table.textC('txt-p-code',pcode);
					table.textC('txt-qtyp',number_format(qtyp,2));
					table.textC('txt-qtys',number_format(qtys,2));
					table.textC('txt-cst',`\u0E3F ${ number_format(cst,2)}`);
					table.textC('txt-p-color',pcolor);
					table.showC('rlf');
					table.findC('btn-success').removeClass('btn-success').addClass('btn-link text-primary');
					table.findC('btn-danger').hide();
					$(e.currentTarget).html(`<i class="fa fa-pencil"></i>&ensp;
						{{ __('edit')}}`);
					$(e.currentTarget).attr('state','saved');
				}
				else{
					table.hideC('rlf');
					table.showC('rf');
					table.findC('btn-link.text-primary').removeClass('btn-link text-primary').addClass('btn-success');
					table.findC('btn-danger').show();
					$(e.currentTarget).html(`<i class="fa fa-save"></i>&ensp;{{ __('save')}}`);
					$(e.currentTarget).attr('state','unsaved');
				}
				updateContent();
			}
			else{
				alert(`ไม่พบสินค้ารหัส${table.valueC('p-code')}`);
				table.focus();
			}
		});
	});


	$('#origin').autocomplete({
		lookup : data.get('p_suggestions'),
		lookupLimit : 20,
		autoSelectFirst : true
	});

	$('#p-color').autocomplete({
		lookup : data.get('clr_suggesrtions'),
		lookupLimit : 20,
		autoSelectFirst : true
	});

	totalQtyp = () => {
		let qtyp = 0;
		$('.qtyp').each((key,val) => {
			let value = ($(val).val() === '' || $(val).val() === null) ? 0 : parseFloat($(val).val());
			qtyp += value;
		});
		return qtyp;
	}

	totalQyps = () => {
		let qtys = 0;
		$('.qtys').each((key,val) => {
			let value = ($(val).val() === '' || $(val).val() === null) ? 0 : parseFloat($(val).val());
			qtys += value;
		});
		return qtys;
	}

	totalCost = () => {
		let cst = 0;
		$('.cst').each((key,val) => {
			let value = ($(val).val() === '' || $(val).val() === null) ? 0 : parseFloat($(val).val());
			cst += value;
		});
		return cst;
	}

	$('input[type=radio][name=unit]').on('change', function(){
		let text = $(this).parent('label').text().trim();
		let qty_text = '{{ __('qty :param',['param'=>'nn']) }}';
		qty_text = qty_text.replace('nn',text);
		$('#sunit').text(qty_text);
		let price_text = '{{ __('import price/:param',['param'=>'nn']) }}';
		price_text = price_text.replace('nn',text);
		$('#price-text').html(price_text);
	});

	updateContent = () => {
		let total_list 	= table.rowCount;
		let total_qtyp 	= totalQtyp();
		let total_qtys 	= totalQyps();
		let total_cst 	= totalCost();
		let total_list_text = "{{__('total n product', ['n' => ':n'])}}";
		let qtys_arr 	= $('.qtys').map(function(){ return $(this).val()}).get();
		let cst_arr 	= $('.cst').map(function(){ return $(this).val()}).get();
		qtys_arr = qtys_arr.filter(v => v !== '' );
		cst_arr = cst_arr.filter(v => v !== '' );
		total = qtys_arr.reduce((result,v,i) => {
			return result + (v * cst_arr[i]);
		},0);
		$('#total-list').html(total_list_text.replace(':n',total_list));
		$('#total-qtyp').html(smallDecimal(total_qtyp));
		$('#total-qtys').html(smallDecimal(total_qtys));
		$('#total-cst').html('\u0E3F '+ smallDecimal(total));
	}

</script>
@endsection