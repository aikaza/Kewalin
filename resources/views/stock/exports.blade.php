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
								<li><a href="{{ route('stock.index') }}">คลังสินค้า</a></li>
								<li class="active">นำสินค้าออก 
								</li>
							</ul>
						</h2>
						<div class="clearfix"></div>
					</div>

					<div class="x_content">
						<br />
						<form method="POST" action="{{ route('order.add') }}" id="add_form">
							{{ csrf_field() }}
							
						</form>

						<div style="padding: 8px;">
							<label class="control-label" for="p_id">
								รหัสอ้างอิงคำสั่งซื้อ <span class="required">*</span>
							</label>
							<div class="form-inline">
								<div class="form-group">
									<input type="text" class="form-control" name="c_id" id="refcode" form="add_form" 
									size="30">
								</div>
								<button type="button" class="btn btn-success" style="margin-top: 5px;" id="refcode-btn"><i class="fa fa-check-square"></i> Check</button>
							</div>
						</div>
						<div class="alert alert-success alert-dismissable" style="margin: 8px;border-radius: 0 !important;display: none;" id="found-alert">
							<a href="#" class="close" onclick="$('#found-alert').hide()" aria-label="close">&times;</a>
							<h5><strong>ข้อมูลลูกค้าหมายเลข <span id="ci-id"></span></strong></h5>
							<p>ชื่อ : <span id="ci-name"></span></p>
							<p>ชื่อเล่น/ชื่อบริษัท : <span id="ci-alias-name"></span></p>
							<p>เบอร์โทร : <span id="ci-phone-no"></span></p>
							<p>ที่อยู่ : 35/1 หมู่ 2 ตำบลบ้านไร่ อำเภอบ้านไร่ จังหวัดอุทัยธานี 61140</p>
						</div>

						<div class="alert alert-danger alert-dismissable" style="margin: 8px;border-radius: 0 !important;display: none;" id="not-found-alert">
							<a href="#" class="close" onclick="$('#not-found-alert').hide()" aria-label="close">&times;</a>
							<h5>ไม่พบข้อมูลลูกค้า</h5>
						</div>

						<div class="form-group">
							<table class="table borderless" id="input-table">
								<thead>
									<tr>
										<th style="width: 25%;">หมายเลขสินค้า</th>
										<th>จำนวนม้วน</th>
										<th>จำนวนหลา</th>
										<th>ราคาขาย/หน่วย</th>
										<th>รวมเป็นเงิน</th>
										<th>ล็อตออก</th>
										<th width="18%" class="text-center">กระทำ</th>
									</tr>
								</thead>
								
								<tbody>
									<tr>
										<td>
											<input type="text"  name="product_id[]" class="form-control p-id rf show" form="add_form" id="origin" required>
											<input type="text" class="form-control fake-p-id rlf hidden" readonly>
										</td>
										<td>
											<input type="number" name="qtyr[]" class="form-control qtyr rf show" form="add_form" min="0" required>
											<input type="text" class="form-control fake-qtyr rlf hidden" readonly>
										</td>
										<td>
											<input type="number" name="qtyy[]" class="form-control qtyy rf show" form="add_form" min="0" required>
											<input type="text" class="form-control fake-qtyy rlf hidden" readonly>
										</td>
										<td>
											<input type="number" name="cst[]" class="form-control cst rf show" form="add_form" min="0" required>
											<input type="text" class="form-control fake-cst rlf hidden" readonly>
										</td>
										<td>
											<input type="text" name="total[]" class="form-control total rf show" form="add_form" onkeypress="return false;" required>
											<input type="text" class="form-control fake-t-cst rlf hidden" readonly>
										</td>
										<td>
											<input type="text" name="lot_number[]" class="form-control lot-number rf show" form="add_form" required>
											<input type="text" class="form-control fake-t-cst rlf hidden" readonly>
										</td>
										<td>
											<button class="btn btn-danger del-btn" type="button" style="float: right" form="add_form">
												<i class="fa fa-trash"></i>&ensp;ลบ
											</button>
											<button class="btn btn-success save-btn" state="unsaved" style="float: right" type="button" form="add_form">
												<i class="fa fa-save"></i>&ensp;บันทึก
											</button>
										</td>
									</tr>
									<tr>
										<td colspan="1" id="total-row" style="font-size: 1.5rem;">ทั้งหมด 1 รายการ</td>
										<td colspan="5" style="font-size: 1.5rem;" id="total-add-c" class="text-center">
											ต้นทุนนำเข้าทั้งหมด  <strong>0</strong> บาท
										</td>
										<td colspan="1">
											<button class="btn btn-success" style="float: right;" id="add-row" type="button" form="add_form">
												<i class="fa fa-plus-circle"></i> เพิ่มแถว
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="form-group">
							<button type="button" class="btn btn-success" form="add_form" id="submit-btn">
								<i class="fa fa-check-circle"></i> เสร็จสิ้น
							</button>
							<button type="button" class="btn btn-primary" form="add_form" id="submit-btn">
								<i class="fa fa-eye"></i> ตรวจสอบ
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

	let data = new Data();
	$.ajax({
		url : '{{ route('ajax.get.refcode.suggestions') }}',
		type: 'GET',
		dataType : 'json',
		async: false
	}).done(res => {
		data.keep('refcode_suggestions',res.suggestions);
	}).fail((xhr,status,error) => {
		console.log("error");
	});

	$.ajax({
		url : '{{ route('ajax.get.product.suggestions') }}',
		type: 'GET',
		dataType : 'json',
		async: false
	}).done(res => {
		data.keep('p_suggestions',res.suggestions);
	}).fail((xhr,status,error) => {
		console.log("error");
	});


	$(document).ready(function(){


		//declare global variable
		let add_btn  	= getElmById('add-row');
		let table       = new InputTable('input-table');
		let table_conf  = table.config = {
			cloneRow : 1,
			rowCount : {
				event : 'minus',
				value : 1
			},
			text : {
				event : 'rowFixed',
				value : 'last'
			}
		}

		// add row
		table.inst.on('click','#add-row',() => {
			let uuid = uuidv4();
			table.addRow(-1);
			table.text(1, `ทั้งหมด ${table.rowCount} รายการ`);
			table.row = table.rowAt(-2);
			table.row.find('input.rf').attr('id', uuid);
			$('#'+uuid).autocomplete({
				lookup : data.get('p-suggestions'),
				onSelect : suggestion => {

				},
				lookupLimit : 20,
				autoSelectFirst : true
			});
			table.focus();

		});

		// delete row
		table.inst.on('click','.del-btn', e => {
			if(table.rowCount > 1){
				if (confirm("ยืนยันการลบรายการ?"))
					table.thisRow(e.currentTarget).remove();
			}
			table.text(1,`ทั้งหมด ${table.rowCount} รายการ`);
			table.text(2,`ต้นทุนนำเข้าทั้งหมด <strong>${number_format(totalCost())}</strong> บาท`);
		});

		// calculate cost
		table.inst.on('input', '.cst, .qtyr', e => {
			table.row = table.thisRow(e.currentTarget);
			let cst = (table.valueC('cst').length === 0) ? 0 : table.valueC('cst');
			let qtyr = (table.valueC('qtyr').length === 0) ? 0 : table.valueC('qtyr');
			let total = cst * qtyr;
			table.valueC('total',total);
		});

		// go to new line after enter
		table.inst.on('keyup','.cst, .total', e => {
			table.row = table.thisRow($(e.currentTarget));
			if(e.keyCode === 13) {
				let res = checkProduct(getId(table.valueC('p-id')));
				if(!$.isEmptyObject(res)){
					table.findC('save-btn').trigger('click');
					add_btn.trigger('click');
				}
				else{
					table.findC('save-btn').trigger('click');
				}
			}
		});

		// submit form
		$('#submit-btn').click(function(){
			table.firstRow.remove();
			$('#add_form').submit();
		});

		// caculate total cost
		totalCost = () => {
			var total = 0;
			$('.total').each( (key, value) => {
				if($(value).val().length === 0) total += 0;
				else total += parseInt($(value).val());
			});
			return total;
		}
		
		// save 
		table.inst.on('click','.save-btn', e => {
			table.row = table.thisRow(e.currentTarget);
			let res = checkProduct(getId(table.valueC('p-id')));
			if(!$.isEmptyObject(res)){
				if ($(e.currentTarget).attr('state') !== 'saved') {
					let pid 	= table.valueC('p-id');
					let cst 	= (table.valueC('cst').length === 0) ? 0 : table.valueC('cst');
					let qtyr 	= (table.valueC('qtyr').length === 0) ? 0 : table.valueC('qtyr');
					let qtyy 	= table.valueC('qtyy');
					let cost 	= cst * qtyr;
					table.hideC('rf');
					table.valueC('fake-p-id',pid);
					table.valueC('fake-qtyr',number_format(qtyr));
					table.valueC('fake-qtyy',number_format(qtyy));
					table.valueC('fake-cst',`\u0E3F ${ number_format(cst)}`);
					table.valueC('fake-t-cst',`\u0E3F ${ number_format(cost)}`);
					table.showC('rlf');
					table.text(2,`ต้นทุนนำเข้าทั้งหมด <strong>${number_format(totalCost())}</strong> บาท`);
					replaceClass(e.currentTarget, 'btn-success', 'btn-primary');
					$(e.currentTarget).html('<i class="fa fa-pencil"></i>&ensp;แก้ไข');
					$(e.currentTarget).attr('state','saved');
				}
				else{
					table.hideC('rlf');
					table.showC('rf');
					replaceClass(e.currentTarget, 'btn-primary', 'btn-success');
					$(e.currentTarget).html('<i class="fa fa-save"></i>&ensp;บันทึก');
					$(e.currentTarget).attr('state','unsaved');
				}
			}
			else{
				alert(`ไม่พบสินค้าหมายเลข${table.valueC('p-id')}`);
				table.focus();
			}
		});
	});

	$('#refcode-btn').click(function(){
		let refcode = $('#refcode').val();
		if(refcode === '' || refcode === null) alert('กรุณากรอกรหัสลูกค้า');
		else{
			let res = checkCustomer(c_id);
			if(res !== false) {
				$('#not-found-alert').hide();
				let falert = $('#found-alert');
				falert.find('#ci-id').text(res['id']);
				falert.find('#ci-name').text(res['first_name']+' '+res['last_name']);
				falert.find('#ci-alias-name').text(res['alias_name']);
				falert.find('#ci-phone-no').text(res['phone_no']);
				falert.show();
				$('#insert-table > tbody > tr:nth-child(2) > td:first > input').focus();
			}else {
				$('#found-alert').hide();
				$('#not-found-alert').show();
			}
		}
	});

	$('#refcode').keyup(e => {
		if(e.keyCode === 13){
			$('#refcode-btn').trigger('click');
		}
	});

	$('#refcode').autocomplete({
		lookup : data.get('refcode_suggestions'),
		lookupLimit : 20,
		autoSelectFirst : true
	});

	$('#origin').autocomplete({
		lookup : data.get('p_suggestions'),
		lookupLimit : 20,
		autoSelectFirst : true
	});

	getId = str => {
		let input = str.split('/');
		id = input[0].replace(/\D/g,'');
		return parseInt(id);
	}

	checkProduct = id => {
		let response = null;
		let url = '{{ route('ajax.check.product',':c_id') }}';
		url = url.replace(':c_id', id);
		$.ajax({
			url: url,
			method: 'GET',
			dataType: 'json',
			async: false
		}).done(res => {
			response = res;
		}).fail( (xhr,status,error) => {
			console.log(JSON.parse(xhr.responseText));
		});
		return response;
	}


	checkCustomer = id => {
		var response = null;
		let url = '{{ route('ajax.check.customer',':c_id') }}';
		url = url.replace(':c_id', id);
		$.ajax({
			url: url,
			method: 'GET',
			dataType: 'json',
			async: false
		}).done( res => {
			if(res !== 'false'){
				response  = res;
			}
		}).fail((xhr,status,error) =>{
			console.log(JSON.parse(xhr.responseText));
		});
		return response;
	}

	getRefCode = (str) => {
		let refcode = $.trim(str.split('/')[0]);
		return refcode;
	}

</script>
@endsection