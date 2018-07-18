@extends('layouts.app')
@include('class.stock-checking-class')
@section('php')
@php
$customer = cInfo($input['c_id']); 
$customer_data = [
	'name' => $customer->first_name.' '.$customer->last_name,
	'alias_name' => $customer->alias_name,
	'address' => $customer->address,
	'phone_no' => $customer->phone_no,
	'email' => $customer->email,
	'onlyrefcode' => $input['refcode']
];

$stock_check = new StockChecking($input['p_id'],$input['p_color'],$input['qtyp'],$input['unit']);
$result_checking = $stock_check->calculate();
$result_checking_bool = true;

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
								<li><a href="{{ route('orders.index') }}">@lang('order')</a></li>
								<li class="active">@lang('export product') 
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
						<br />
						<form method="POST" action="{{ route('exports.store') }}" id="add_form">
							{{ csrf_field() }}
							<input type="hidden" name="input" value="{{ base64_encode(serialize($input)) }}">
							<input type="hidden" name="pattern" value="{{$pattern}}">
						</form>
						@include('custom.customer-info',$customer_data)	
						<div class="form-group">
							<table class="table table-bordered table-cell jambo_table jambo_border padleft-table" id="input-table">
								<thead>
									<tr>
										<th style="vertical-align: middle;width: 40%;" class="text-center" 
										rowspan="2">
										#@lang('product') &bull; @lang('color')
									</th>

									<th colspan="3" id="sunit">@lang('unit') &ensp;
										{{ unitName($input['unit']) }}
									</th>
								</tr>
								<tr>
									<th>@lang('qty :param',['param' => __('roll')])</th>
									<th>
										@lang('qty :param',['param'=>unitName($input['unit'])])
									</th>
									<th>@lang('export lot')</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($input['order_id'] as $i => $od)
								<tr>
									<td style="padding-left: 16px !important;">
										@php
										$pd = pInfo($input['p_id'][$i]);
										@endphp
										#{{ $pd->code }} / {{ $input['p_color'][$i] }} {{ $pd->name }}
									</td>
									<td style="padding-left: 16px !important;"> 
										{{ $input['qtyp'][$i] }} 
									</td>
									<td style="padding-left: 16px !important;"> 
										@if ($pattern === '1')
										{{ array_sum($input['qtys'][$i]) }}
										@else
										{{ $input['qtys'][$i] }}
										@endif
									</td>
									<td style="padding-left: 16px !important;cursor: pointer;" class="triggerable">
										@php
										$value = '';
										if ($result_checking[$i] === null) {
											$value = "สินค้าในสต็อกไม่เพียงพอ";
											$result_checking_bool = false;
										}
										else{
											$lot_to_export = [];
											$value =  $result_checking[$i];		
										}
										@endphp
										<input type="hidden" name="lot_no[]" value="{{$value}}" form="add_form">
										{{ $value }}
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="form-group">
						@if ($result_checking_bool)
						<button type="submit" class="btn btn-success" form="add_form" id="submit-btn">
							<i class="fa fa-check-circle"></i> Submit
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