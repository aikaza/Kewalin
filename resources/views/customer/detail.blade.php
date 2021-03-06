@extends('layouts.app')

@include('class.customer-detail-class')
@section('php')
@php
	$customer = new CustomerDetail($ct->id);
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
									<a href="{{ route('customers.index') }}">
										@lang('customer')
									</a>
								</li>
								<li class="active">
									@lang('customer')
									<code>
										#{{ $ct->id }}
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
										@include('customer.detail.statistic')
									</div>
									<div class="row">
										@include('customer.detail.tab-data')
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

