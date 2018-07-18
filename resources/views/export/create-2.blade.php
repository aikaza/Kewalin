@extends('layouts.app')
@section('php')
@php
$units = units();
$init_unit = App::isLocale('th') ? $units->first()->name : $units->first()->name_eng;
$customer_data = [
	'name' => $data[0]->customer->first_name.' '.$data[0]->customer->last_name,
	'alias_name' => $data[0]->customer->alias_name,
	'address' => $data[0]->customer->address,
	'phone_no' => $data[0]->customer->phone_no,
	'email' => $data[0]->customer->email,
	'refcode' => $data[0]->code->id,
	'pattern' => 1,
	'export_text' => __('export with details')
];
$stock_error_list = [];
function checkStockBeforeExport($data,&$stock_error_list){
	foreach ($data as $da) {
		if(premainCount($da->product_id) < $da->qtyp){
			array_push($stock_error_list, '#'.$da->product->code.' '.$da->product->name);
		}
	}
	return (empty($stock_error_list)) ? true : false;
}
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
									<a href="{{ route('orders.index') }}">
										@lang('order')
									</a>
								</li>
								<li class="active">@lang('export product') 
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
						<form method="POST" action="{{ route('exports.pre',2) }}" id="add_form">
							{{ csrf_field() }}
							<input type="hidden" name="c_id" value="{{$data[0]->customer->id}}">
							<input type="hidden" name="refcode" value="{{$data[0]->refcode }}">
						</form>
						@include('custom.customer-info',$customer_data)	
						@if (!checkStockBeforeExport($data,$stock_error_list))
						<div class="jumbotron" style="padding: 16px;">
							<p style="font-size: 2rem">
								<strong>ข้อผิดพลาด!</strong> คุณไม่สามารถทำรายการส่งออกได้ เนื่องจากสินค้ามีไม่เพียงพอ 
								<ul style="font-size: 1.5rem">
									@foreach ($stock_error_list as $dt)
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
										<th style="vertical-align: middle;width: 40%;" class="text-center kg" 
										rowspan="2">
										#@lang('product') &bull; @lang('color')
									</th>
									<th colspan="2" id="sunit">@lang('unit') &ensp;
										@foreach ($units as $i => $unit)
										<label class="clickable">
											<input type="radio" name="unit" value="{{$unit->id}}" form="add_form" {{ ($i === 0) ? 'checked' : '' }}>
											{{ App::isLocale('th') ? $unit->name : $unit->name_eng }}
										</label>
										@endforeach
									</th>
								</tr>
								<tr>
									<th>@lang('qty :param', ['param' => __('roll')])</th>
									<th id="qtys-text">
										@lang('qty :param', ['param' => App::isLocale('th') ? 'หลา' : 'Yard'])
									</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($data as $i => $d)
								<input type="hidden" name="qtyp[]" value="{{$d->qtyp}}" form="add_form">
								<input type="hidden" name="p_id[]" value="{{$d->product_id}}" form="add_form">
								<input type="hidden" name="p_color[]" value="{{$d->product_color}}" form="add_form">
								<input type="hidden" name="order_id[]" value="{{$d->id}}" form="add_form">
								<tr>
									<td>
										<input type="text" class="form-control input-cell"
										value="#{{ $d->product->code }} &emsp; {{ $d->product->name }} &bull; {{ checkProductColor($d->product_color) }}" readonly>
									</td>
									<td>
										<input type="text" class="form-control input-cell"
										value="{{ $d->qtyp }}" readonly>
									</td>
									<td>
										<input type="text" name="qtys[]" class="form-control input-cell" form="add_form" placeholder="#{{$i+1}}" required>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success" form="add_form" id="submit-btn">
							<i class="fa fa-check-circle"></i> Submit
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
		let text = $(this).parent('label').text().trim();
		let qty_text = '{{ __('qty :param',['param'=>'nn']) }}';
		qty_text = qty_text.replace('nn',text);
		$('#qtys-text').text(qty_text);
	});

	$('.label').click(function(){
		$(this).find('input[type=radio]').prop('checked',true);
	});

	

</script>
@endsection