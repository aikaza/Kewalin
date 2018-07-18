@extends('layouts.app')

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
									<a href="{{ route('orders.index') }}">
										@lang('order')
									</a>
								</li>
								<li class="active">
									@lang('new record') 
									&ensp;&ensp;สำหรับ 
								</li>
							</ul>
						</h2>
						<ul class="nav navbar-left panel_toolbox">
							<li>
								<select class="form-control" name="created_for" form="add_form" required id="created_for_select">
									<option value="" disabled selected>กรุณาเลือกแผนก</option>
									<option value="ext_minor">ฝ่ายโกดัง</option>
									<option value="ext_major">ฝ่ายหน้าร้าน</option>
								</select>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>

					<div class="x_content">
						<br />
						<form method="POST" action="{{ route('orders.store') }}" id="add_form">
							{{ csrf_field() }}
							<input type="hidden" name="uuid" value="{{(string)\Uuid::generate()}}">
						</form>
						<div>
							<label class="control-label" for="p_id">
								@lang('customer')
								<span class="required">*</span>
							</label>
							<div class="form-inline">
								<div class="form-group">
									<input type="text" class="form-control" name="c_id" id="c-id" form="add_form" required>
								</div>
								<button type="button" class="btn btn-success" style="margin-top: 5px;" id="c-btn">
									<i class="fa fa-check-square"></i>
									@lang('check')
								</button>
							</div>
						</div>
						<div class="alert jumbotron-alert alert-dismissable" style="border-radius: 0 !important;display: none;" id="found-alert">
							<a href="#" class="close" onclick="$('#found-alert').hide()" aria-label="close">&times;</a>
							<h5>
								<strong>@lang('the information of customer') 
									#<span id="ci-id"></span>
								</strong>
							</h5>
							<p>@lang('name') : 
								<span id="ci-name"></span>
							</p>
							<p>@lang('alias name') : 
								<span id="ci-alias-name"></span>
							</p>
							<p>@lang('email') : 
								<span id="ci-email"></span>
							</p>
							<p>@lang('phone number') : 
								<span id="ci-phone-no"></span>
							</p>
							<p>@lang('address') : 
								<span id="ci-address"></span>
							</p>
						</div>

						<div class="alert jumbotron-alert alert-dismissable" style="border-radius: 0 !important;display: none;" id="not-found-alert">
							<a href="#" class="close" onclick="$('#not-found-alert').hide()" aria-label="close">&times;</a>
							<h5>
								@lang('customer not found')
							</h5>
						</div>

						<div class="form-group">
							<table class="table table-striped table-bordered input-table jambo_table" id="order-add-table">
								<thead>
									<tr>
										<th rowspan="2"># @lang('product code')</th>
										<th rowspan="2" width="20%"># @lang('color')</th>
										<th colspan="3">@lang('detail')</th>
									</tr>
									<tr>
										<th>@lang('qty :param',['param'=>__('roll')])</th>
										<th width="20%" class="text-center" colspan="2">
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
											<input type="text"  name="p_color[]" class="form-control p-color rf show" form="add_form" id="p-color">
											<span class="txt-p-color rlf hidden"></span>
										</td>
										<td>
											<input type="text" name="qtyp[]" class="form-control qtyp rf show" form="add_form" min="0" required>
											<span class="txt-qtyp rlf hidden" ></span>
										</td>
										<td style="width: 10%">
											<button class="btn btn-success save-btn btn-block" state="unsaved" type="button" form="add_form">
												<i class="fa fa-save"></i>&ensp;
												@lang('save')
											</button>
										</td>
										<td style="width: 10%">
											<button class="btn btn-danger del-btn btn-block" type="button" form="add_form">
												<i class="fa fa-trash"></i>&ensp;
												@lang('delete')
											</button>
										</td>
									</tr>
								</tbody>
								<tfoot>
									<tr id="sumary">
										<th colspan="2">
											@lang('total')
											<span id="total-list">1</span>
											@lang('product')
										</th>
										<th>
											<span id="total-qtyp">0</span> 
											@lang('roll')
										</th>
										<th colspan="2">
											<button class="btn btn-default btn-block" id="add-row" 
											type="button" form="add_form">
											<i class="fa fa-plus-circle"></i>
											@lang('add row')
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
	let table       = new InputTable('order-add-table');
	let table_conf  = table.config = {
		cloneRow : 1,
		text : {
			event : 'rowFixed',
			value : 'last',
			in : 'tfoot'
		}
	}
	
	initSuggestion('product',function(res){
		data.keep('p_suggestions',res.suggestions);
	});
	initSuggestion('customer',function(res){
		data.keep('c_suggestions',res.suggestions);
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
			save_html = save_html.replace(':save',"{{ __('save')}}");
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


		// go to new line after enter
		table.inst.on('keyup','.p-code,.p-color ,.qtyp', e => {
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
						let res2 = checkColor(table.valueC('p-color'));
						if(res && res2){
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

		$('#c-id').keyup( e => {
			if(e.keyCode === 13) {
				$('#c-btn').trigger('click');
			}
		}); 

		// submit form
		$('#submit-btn').click(function(){
			if($('#created_for_select').find(':selected').val() === ""){
				alert('กรุณาเลือกแผนก');
			}
			else if($('#c-id').val() === ""){
				alert('กรุณากรอกรหัสลูกค้า');
			}
			else{
				table.findC('save-btn').trigger('click');
				$('.p-code').each((key,val) => {
					$(val).val(getProductCode($(val).val()));
				});
				$('#c-id').val(getId($('#c-id').val()));
				$(this).prop('disabled',true);
				$('#add_form').submit();
			}
		});



		// save 
		table.inst.on('click','.save-btn', e => {
			table.row = table.thisRow(e.currentTarget);
			if ($(e.currentTarget).attr('state') !== 'saved'){
				if(!checkColor(table.valueC('p-color'))){
					if(!confirm("{{ __('order:create color code not found warning')}}")){
						return false;
					}
				}
			}
			if(Product.check(table.valueC('p-code'))){
				if ($(e.currentTarget).attr('state') !== 'saved') {
					let pid 	= table.valueC('p-code');
					let pcolor 	= table.valueC('p-color');
					let qtyp 	= (table.valueC('qtyp').length === 0) ? 0.00 : parseFloat(table.valueC('qtyp'));
					table.hideC('rf');
					table.textC('txt-p-code',pid);
					table.textC('txt-p-color',pcolor);
					table.textC('txt-qtyp',number_format(qtyp,2));
					table.showC('rlf');
					table.findC('btn-success').removeClass('btn-success').addClass('btn-link text-primary');
					table.findC('btn-danger').hide();
					$(e.currentTarget).html(`<i class="fa fa-pencil"></i>&ensp;
						{{ __('edit')}} `);
					$(e.currentTarget).attr('state','saved');
				}
				else{
					table.hideC('rlf');
					table.showC('rf');
					table.findC('btn-link.text-primary').removeClass('btn-link text-primary').addClass('btn-success');
					table.findC('btn-danger').show();
					$(e.currentTarget).html(`<i class="fa fa-save"></i>&ensp;
						{{ __('save')}} `);
					$(e.currentTarget).attr('state','unsaved');
				}
			}
			else{
				alert(`ไม่พบสินค้าหมายเลข${table.valueC('p-code')}`);
				table.focus();
			}
			updateContent();
		});
	});

	getId = str => {
		let input = str.split('|');
		id = input[0].replace(/\D/g,'');
		return parseInt(id);
	}

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

	$('#c-id').autocomplete({
		lookup : data.get('c_suggestions'),
		lookupLimit : 20,
		autoSelectFirst : true
	});

	$('#c-btn').click(function(){
		let c_id = $('#c-id').val();
		if(!c_id) alert('กรุณากรอกรหัสลูกค้า');
		else{
			let res = checkCustomer(getId(c_id));
			if(res !== null) {
				$('#not-found-alert').hide();
				let falert = $('#found-alert');
				falert.find('#ci-id').text(res['id']);
				falert.find('#ci-name').text(res['first_name']+' '+res['last_name']);
				falert.find('#ci-email').text(res['email']);
				falert.find('#ci-alias-name').text(res['alias_name']);
				falert.find('#ci-phone-no').text(res['phone_no']);
				falert.find('#ci-address').text(res['address']);
				falert.show();
				$('#insert-table > tbody > tr:nth-child(2) > td:first > input').focus();
			}else {
				$('#found-alert').hide();
				$('#not-found-alert').show();
			}
		}
	});

	totalQtyp = () => {
		let qtyp = 0;
		$('.qtyp').each((key,val) => {
			let value = ($(val).val() === '' || $(val).val() === null) ? 0 : parseFloat($(val).val());
			qtyp += value;
		});
		return qtyp;
	}


	updateContent = () => {
		let total_list = table.rowCount;
		let total_qtyp = totalQtyp();
		$('#total-list').text(total_list);
		$('#total-qtyp').text(number_format(total_qtyp,2));
	}

	checkCustomer = id => {
		var response = null;
		$.ajax({
			url: '/api/customer/'+id+'/get',
			method: 'GET',
			dataType: 'json',
			async: false
		}).done( res => {
			if(!$.isEmptyObject(res)){
				response  = res;
			}
		}).fail((xhr,status,error) =>{
			console.log(JSON.parse(xhr.responseText));
		});
		return response;
	}
	checkColor = color => {
		var response = null;
		$.ajax({
			url: apiURL('color:check',color),
			method: 'GET',
			dataType: 'json',
			async: false
		}).done( res => {
			response = res;
		}).fail((xhr,status,error) =>{
			console.log(JSON.parse(xhr.responseText));
		});
		return response;
	}
</script>
@endsection