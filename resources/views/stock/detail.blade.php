@extends('layouts.app')

@include('class.product-detail-class')
@section('php')
@php
	$product = new ProductDetail($pd->id);
@endphp
@endsection
@section('content')

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
									@lang('detail')
									<code>
										#{{ $pd->code }} {{ $pd->name }}
									</code>
								</li>
							</ul>
						</h2>
						<div class="clearfix"></div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="">
								<div class="x_content">
									<div class="row">
										@include('stock.detail.topbar-statistic')
									</div>
									<div class="row">
										@include('stock.detail.tab-list')
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- /page content -->


@endsection

@section('php')
@php
function status($no){



}
@endphp
@endsection