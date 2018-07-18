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
									<small>
										ของคุณ 
										{{ $data[0]->customer->first_name }}
										{{ $data[0]->customer->last_name }}
										({{ $data[0]->customer->alias_name }})
									</small>
								</li>
							</ul>
						</h2>
						<div class="clearfix"></div>
					</div>

					<div class="x_content">
						<br />
						<form method="POST" action="{{ route('export.pre') }}" id="add_form">
							{{ csrf_field() }}
							<input type="hidden" name="c_id" value="{{$data[0]->customer->id}}">
							<input type="hidden" name="refcode" value="{{$data[0]->refcode }}">
						</form>

						<div style="padding: 8px;">
							<label class="control-label" for="refcode">
								ผู้สั่งซื้อ : {{ $data[0]->customer->first_name }} {{ $data[0]->customer->last_name }}
							</label><br>
							<label class="control-label" for="refcode">
								ชื่อเล่น/ชื่อบริษัท : {{ $data[0]->customer->alias_name }}
							</label><br>
							<label class="control-label" for="refcode">
								ที่อยู่ : 35/1 หมู่ 2 ตำบลบ้านไร่ อำเภอบ้านไร่ จังหวัดอุทัยธานี 61140
							</label><br>
							<label class="control-label" for="refcode">
								เบอร์โทรศัพท์ : {{ $data[0]->customer->phone_no }}
							</label><br>
							<label class="control-label" for="refcode">
								รหัสอ้างอิงคำสั่งซื้อ : {{$data[0]->refcode}}
							</label>
						</div>
						
						@php $exception = false; @endphp
						@php $detail = []; @endphp
						@foreach ($data as $da)
						@if (premainCount($da->product_id) < $da->qtyp)
						@php $exception = true; @endphp
						@php 
						array_push($detail, '#'.$da->product_id.' '.$da->product->name); 
						@endphp
						@endif
						@endforeach
						@if ($exception)
						<div class="jumbotron" style="padding: 16px;">
							<p style="font-size: 2rem">
								<strong>ข้อผิดพลาด!</strong> คุณไม่สามารถทำรายการส่งออกได้ เนื่องจากสินค้ามีไม่เพียงพอ 
								<ul style="font-size: 1.5rem">
									@foreach ($detail as $dt)
									<li>{{ $dt }}</li>
									@endforeach
								</ul>
							</p>
						</div>
						@else
						<div class="form-group">
							<table class="table table-bordered table-cell jambo_table jambo_border">
								<thead>
									<tr>
										<th style="vertical-align: middle;width: 20%;display: none;" class="text-center kg" 
										rowspan="2">
										# หมายเลขสินค้า
									</th>
									<th style="vertical-align: middle;width: 25%" class="text-center ym" rowspan="2"># หมายเลขสินค้า
										<br>
										ราคาขาย
									</th>
									<th colspan="8" id="sunit">ส่งสินค้าแบบ &ensp;
										<input type="radio" name="unit" value="y" form="add_form" checked> หลา
										<input type="radio" name="unit" value="m" form="add_form" > เมตร
										<input type="radio" name="unit" value="kg" form="add_form" > กิโลกรัม
									</th>
								</tr>
								<tr>
									<th colspan="8" class="ym">กรอกรายละเอียดสินค้า</th>
									<th class="kg" style="display: none;">จำนวนม้วน</th>
									<th class="kg" style="display: none;">จำนวนกิโล</th>
									<th class="kg" style="display: none;">ราคาขาย/ม้วน</th>
									<th class="kg" style="display: none;">เป็นเงิน</th>
								</tr>
							</thead>
							<tbody>
								@php $count_index = 0; @endphp
								@foreach ($data as $d)
								<input type="hidden" name="qtyp[]" value="{{$d->qtyp}}" form="add_form">
								<input type="hidden" name="p_id[]" value="{{$d->product_id}}" form="add_form">
								<input type="hidden" name="order_id[]" value="{{$d->id}}" form="add_form">
								@php
								$count_row = ($d->qtyp / 8 > 2) ? ceil($d->qtyp / 8) : 2;
								$fill_row = ($d->qtyp > 8) ? false : true;
								$count_fraction = ($d->qtyp % 8 === 0) ? 0 : 8 - ($d->qtyp % 8);
								@endphp
								@for ($i = 1; $i <= $d->qtyp; $i++)
								@if ($i % 8 === 1) <tr class="ym"> @endif
									@if ($i === 1)
									<td rowspan="{{$count_row}}" style="vertical-align: middle;text-align: center;">
										#{{ $d->product_id }} / {{ $d->product->name }}{{ $d->product_color}}<br>
										<small>จำนวน {{ $d->qtyp }} ม้วน</small>
										<input type="text" name="price_per_unit[]" class="borderless" placeholder="ราคาขาย/ม้วน" form="add_form" value="{{rand(10,99)}}">
									</td>
									@endif
									<td>
										<input type="text" name="qtys[{{$count_index}}][]" placeholder="#{{$i}}" class="form-control input-cell" form="add_form" value="{{rand(10,99)}}">
									</td>

									@if ($i === $d->qtyp && $count_fraction !== 0)
									<td class="active" colspan="{{$count_fraction}}"></td>
									@endif
									@if ($i % 8 === 0 || $i === $d->qtyp) </tr> @endif
									@if ($i === $d->qtyp)
									@if ($fill_row === true)
									<tr class="ym">
										<td class="active" colspan="8"></td>
									</tr>
									@endif
									@endif
									@endfor

									<tr class="kg" style="display: none;">
										<td>
											<input type="text" class="form-control input-cell"
											value="#{{$d->product->code}} / {{$d->product->color}} {{$d->product->name}}" readonly>
										</td>
										<td>
											<input type="text" class="form-control input-cell"
											value="{{ $d->qtyp }}" readonly>
										</td>
										<td>
											<input type="text" name="qtys[]" class="form-control input-cell" form="add_form" value="{{rand(10,99)}}">
										</td>
										<td>
											<input type="text" name="price_per_unit[]" class="form-control input-cell"
											form="add_form" value="{{rand(10,99)}}">
										</td>
										<td>
											<input type="text" name="" class="form-control input-cell" readonly>
										</td>
									</tr>
									@php $count_index++; @endphp
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-success" form="add_form" id="submit-btn">
								<i class="fa fa-check-circle"></i> เสร็จสิ้น
							</button>
							<button type="button" class="btn btn-primary" form="add_form" id="submit-btn">
								<i class="fa fa-eye"></i> ตรวจสอบ
							</button>
						</div>
						@endif
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

	$('input[type=radio][name=unit]').on('change', function(){
		let unit = $(this).val();
		if(unit === 'kg'){
			$('.ym').hide();
			$('#sunit').attr('colspan','4');
			$('.kg').show();
		}
		else{
			$('.kg').hide();
			$('#sunit').attr('colspan','8');
			$('.ym').show();
		}
	});

	$(document).ready(function(){



		getId = str => {
			let input = str.split('/');
			id = input[0].replace(/\D/g,'');
			return parseInt(id);
		}

		//declare global variable
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


		// calculate cost
		table.inst.on('input', '.prices', e => {
			table.row = table.thisRow(e.currentTarget);
			let price = (table.valueC('prices').length === 0) ? 0 : table.valueC('prices');
			let qtyr = (table.valueC('qtyr').length === 0) ? 0 : table.valueC('qtyr');
			let total = price * qtyr;
			table.valueC('total',total);
		});

		// go to new line after enter
		table.inst.on('keyup','.prices, .total, .lot-number', e => {
			table.row = table.thisRow($(e.currentTarget));
			if(e.keyCode === 13) {
				table.findC('save-btn').trigger('click');
			}
		});

		// submit form
		$('#submit-btn').click(function(){
			let unit = $('input[type=radio][name=unit]:checked').val();
			if(unit === 'kg'){
				$('.ym').remove();
			}
			else{
				$('.kg').remove();
			}
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
			if ($(e.currentTarget).attr('state') !== 'saved') {
				let pid 	= table.valueC('p-id');
				let prices 	= (table.valueC('prices').length === 0) ? 0 : table.valueC('prices');
				let qtyr 	= (table.valueC('qtyr').length === 0) ? 0 : table.valueC('qtyr');
				let qtyy 	= table.valueC('qtyy');
				let cost 	= prices * qtyr;
				table.text(2,`จำนวนเงินนำออกทั้งหมด <strong>${number_format(totalCost())}</strong> บาท`);
				replaceClass(e.currentTarget, 'btn-success', 'btn-primary');
				$(e.currentTarget).html('<i class="fa fa-pencil"></i>&ensp;แก้ไข');
				$(e.currentTarget).attr('state','saved');
				$(table.row).find('input').attr('readonly','readonly');
				$(table.row).next().find('.prices').focus();
			}
			else{
				replaceClass(e.currentTarget, 'btn-primary', 'btn-success');
				$(e.currentTarget).html('<i class="fa fa-save"></i>&ensp;บันทึก');
				$(e.currentTarget).attr('state','unsaved');
				$(table.row).find('input.prices, input.total, input.lot-number').removeAttr('readonly');
			}
		});

	});

</script>
@endsection