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
								<li><a href="{{ route('orders.index') }}">คลังสินค้า</a></li>
								<li class="active">นำสินค้าออก 
									<small>
										@php 
										$customer = cInfo($data['c_id']); 
										@endphp
										{{ $customer->first_name }}
										{{ $customer->last_name }}
										({{ $customer->alias_name }})
									</small>
								</li>
							</ul>
						</h2>
						<div class="clearfix"></div>
					</div>

					<div class="x_content">
						<br />
						<form method="POST" action="{{ route('exports.store') }}" id="add_form">
							{{ csrf_field() }}
							<input type="hidden" name="c_id" value="{{$data['c_id']}}">
							<input type="hidden" name="refcode" value="{{$data['refcode']}}">
							<input type="hidden" name="unit" value="{{$data['unit']}}">
						</form>
						<table class="list-table" style="margin-bottom: 16px">
							<tbody>
								<tr>
									<td>
										@lang('messages.customer:name:alt') 
									</td>
									<td>
										{{ $customer->first_name }}
										{{ $customer->last_name }}
									</td>
								</tr>
								<tr>
									<td>
										@lang('messages.customer:alias_name') 
									</td>
									<td>
										{{ $customer->alias_name }}
									</td>
								</tr>
								<tr>
									<td>
										@lang('messages.customer:address') 
									</td>
									<td>
										{{ $customer->address->text }}
									</td>
								</tr>
								<tr>
									<td>
										@lang('messages.customer:phone') 
									</td>
									<td>
										{{ $customer->phone_no }}
									</td>
								</tr>
								<tr>
									<td>
										@lang('messages.customer:email') 
									</td>
									<td>
										{{ $customer->email }}
									</td>
								</tr>
								<tr>
									<td>
										@lang('messages.order:refcode') 
									</td>
									<td>
										{{$data['refcode']}}
									</td>
								</tr>
							</tbody>
						</table>
						<div class="form-group">
							<table class="table table-bordered table-cell jambo_table jambo_border padding-table" id="input-table">
								<thead>
									<tr>
										<th style="vertical-align: middle;width: 20%;display: none;" class="text-center kg" 
										rowspan="2">
										# หมายเลขสินค้า
									</th>
									<th style="vertical-align: middle;width: 25%" class="text-center ym" rowspan="2"># หมายเลขสินค้า
									</th>
									<th colspan="5" id="sunit">ส่งสินค้าแบบ &ensp;
										@if ($data['unit'] === 'y')
										หลา
										@elseif($data['unit'] === 'm')
										เมตร
										@else
										กิโลกรัม
										@endif
									</th>
								</tr>
								<tr>
									<th>จำนวนม้วน</th>
									<th>
										@if ($data['unit'] === 'y')
										จำนวนหลา
										@elseif($data['unit'] === 'm')
										จำนวนเมตร
										@else
										จำนวนกิโลกรัม
										@endif
									</th>
									<th>ราคาขาย/ม้วน</th>
									<th>เป็นเงิน</th>
									<th>ล็อตออก</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($data['p_id'] as $i => $p)
								<input type="hidden" name="order_id[]" form="add_form" 
								value="{{ $data['order_id'][$i]}}">
								<tr>
									<td> 
										#{{ $p }} 
										<input type="hidden" name="p_id[]" form="add_form" value="{{$p}}">
									</td>
									<td> 
										{{ $data['qtyp'][$i] }} 
										<input type="hidden" name="qtyp[]" form="add_form" value="{{$data['qtyp'][$i]}}">
									</td>
									<td style="padding: 8px"> 
										@if ($data['unit'] === 'kg')
										{{ $data['qtys'][$i] }}
										<input type="hidden" name="qtys[]" form="add_form" value="{{$data['qtys'][$i]}}">
										@else
										{{ sumArr($data['qtys'][$i]) }} <br>
										@foreach ($data['qtys'][$i] as $qtys)
										<input type="hidden" name="qtys[{{$i}}][]" form="add_form" 
										value="{{$qtys}}">
										@endforeach
										@endif
									</td>
									<td style="cursor: pointer;" class="triggerable">
										@php
										$lot_no = scheckLot($p,$data['qtyp'][$i],$data['unit']);
										$lot_txt = "";
										$modal_id = str_random(8);
										@endphp
										@if ($lot_no === null)
										@php 
										$lot_txt = 'สินค้าในสต็อกไม่เพียงพอ'; 
										@endphp
										@else
										@foreach($lot_no as $lot_number => $qtyp)
										@php 
										$lot_txt .= $lot_number;
										$lot_txt .= '=';
										$lot_txt .= $qtyp;
										@endphp
										@php
										end($lot_no);
										@endphp 
										@if ($lot_number !== key($lot_no))
										@php $lot_txt .= ','; @endphp
										@endif
										@endforeach
										@endif
										{{ $lot_txt }}
										<input type="hidden" name="lot_no[]" value="{{$lot_txt}}" form="add_form">
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="form-group">
						@if ($lot_no !== null)
						<button type="submit" class="btn btn-success" form="add_form" id="submit-btn">
							<i class="fa fa-check-circle"></i> เสร็จสิ้น
						</button>
						@endif
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
	

</script>
@endsection