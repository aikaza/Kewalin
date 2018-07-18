@extends('layouts.app')

@section('content')

<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_title">	
					<h2>
						<ul class="breadcrumb" style="padding: 0;background-color: transparent;margin: 0">
							<li>
								<a href="{{ route('exports.index') }}">
									@lang('export')
								</a>
							</li>
							<li class="active">
								@lang('detail')
								<small>{{ $exports[0]->order->code->code }}</small>
							</li>
						</ul>
					</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table class="list-table" style="margin-bottom: 16px">
						<tbody>
							<tr>
								<td>@lang('customer')</td>
								<td>{{ $exports[0]->order->customer->first_name }}</td>
							</tr>
							<tr>
								<td>@lang('order number')</td>
								<td>{{ $exports[0]->order->code->code }}</td>
							</tr>
							<tr>
								<td>@lang('date')</td>
								<td>{{ explode(' ', $exports[0]->created_at)[0] }}</td>
							</tr>
							<tr>
								<td>@lang('export by')</td>
								<td>
									@if ($exports[0]->user->role === 'ext_minor')
									ฝ่ายส่งของ (โกดัง)
									@else
									ฝ่ายส่งของ (หน้าร้าน)
									@endif
								</td>
							</tr>
						</tbody>
					</table>
					<table id="ordertable" class="table table-striped table-bordered jambo_table hoveron padding-table">
						<thead>
							<tr>
								<th>#</th>
								<th>@lang('product')</th>
								<th>@lang('qty :param',['param' => __('roll')])</th>
								<th>@lang('qty :param',['param' => unitName($exports[0]->unit->id)])</th>
								<th>@lang('detail')</th>
								<th>@lang('price')</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($exports as $index => $e)
							<tr>
								<td>{{ $index + 1}}</td>
								<td>{{ $e->order->product->code }} / {{ $e->order->product_color }} {{ $e->order->product->name }}</td>
								<td>{{ $e->order->qtyp }}</td>
								<td>{{ $e->qtys }}</td>
								<td>
									@php
										$arr_detail = explode(',', $e->detail);
									@endphp
									@foreach ($arr_detail as $d)
										{{ $d }},  
									@endforeach
								</td>
								<td style="width: 8%">&#3647; {{ $e->price_per_unit }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->


@endsection

