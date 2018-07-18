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
								<a href="{{ route('stocks.index') }}">
									@lang('stock')
								</a>
							</li>
							<li>
								<a href="{{ route('stocks.product.color.detail',$product_id) }}">
									@lang('product remain') 
									<code>
										#{{ pInfo($product_id)->code }}
										{{ pInfo($product_id)->name }}
									</code>
								</a>
							</li>
							<li class="active">
								@lang('lot number')  
								<code>
									{{ $lot_number }}
								</code>
							</li>
						</ul>
					</h2>
					<ul class="nav navbar-right panel_toolbox">
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="s-table" class="table table-striped table-bordered jambo_table custom-table full-width hoveron">
						<thead>
							<tr>
								<th style="width: 10%">#</th>
								<th>@lang('color')</th>
								<th>@lang('remain')</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data->colors as $index => $color_detail)
							<tr>
								<td>
									{{ $index + 1}}
								</td>
								<td>
									{{ $color_detail->color_code }}
								</td>
								<td>
									{{ $color_detail->qtyp }}
								</td>
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
