<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="tile-stats">
		<div class="icon">
			<i class="fa fa-btc">

			</i>
		</div>
		<div class="count">
			{{ number_format($customer->getCustomerTotalDebt()) }}
		</div>
		<h3>
			@lang('debt alt')
		</h3>
		<p>
			@lang('total outstanding debt')
		</p>
	</div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="tile-stats">
		<div class="icon">
			<i class="fa fa-exchange"></i>
		</div>
		<div class="count">
			{{ number_format($customer->getCustomerOrderCount()) }}
		</div>
		<h3>
			@lang('order qty')
		</h3>
		<p>
			@lang('number of ordered products (roll)')
		</p>
	</div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="tile-stats">
		<div class="icon"><i class="fa fa-shopping-basket"></i>
		</div>
		<div class="count">
			@if ($customer->getCustomerFavoriteProduct() === null)
			@lang('no fav')
			@else
			#{{ $customer->getCustomerFavoriteProduct()->product_id }}
			@endif
		</div>
		<h3>
			@lang('favorite')
		</h3>
		<p>
			@if ($customer->getCustomerFavoriteProduct() === null)
			@lang('there is no favorite product')
			@else
			@lang('favorite product is :f',['f' => $customer->getCustomerFavoriteProduct()->product->code.' / '.$customer->getCustomerFavoriteProduct()->product_color])
			@endif
		</p>
	</div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="tile-stats">
		<div class="icon"><i class="fa fa-sort-numeric-asc"></i>
		</div>
		<div class="count">
			{{ $customer->getCustomerSupportRanking() }}
		</div>
		<h3>
			@lang('ranking')
		</h3>
		<p>
			@lang('support ranking (by number of orders)')
		</p>
	</div>
</div>
