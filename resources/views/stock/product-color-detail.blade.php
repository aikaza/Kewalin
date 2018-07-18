@extends('layouts.app')

@section('php')
@php
$index = 0;
@endphp
@endsection
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
							<li class="active">
								@lang('product remain') 
								<code>
									#{{ pInfo($product_id)->code }}
									{{ pInfo($product_id)->name }}
								</code>
							</li>
						</ul>
					</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="s-table" class="table table-striped table-bordered jambo_table custom-table full-width hoveron" id="datatable">
						<thead>
							<tr>
								<th style="width: 10%">#</th>
								<th>@lang('lot number')</th>
								<th>@lang('color')</th>
								<th>@lang('remain')</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $d)
							@foreach ($d->colors as $color_detail)
							@php
							$index++;
							@endphp
							<tr>
								<td>
									{{ $index }}
								</td>
								<td>
									{{ $d->lot_number }}
								</td>
								<td>
									{{ $color_detail->color_code }}
								</td>
								<td>
									{{ $color_detail->qtyp }}
								</td>
							</tr>			
							@endforeach
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

@section('sc')
<script type="text/javascript">
	
	$(document).ready( function () {

		$('#datatable').DataTable();
	} );

</script>
@endsection
