<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="tile-stats">
		<div class="icon">
			<i class="fa fa-bitbucket">
				
			</i>
		</div>
		<div class="count">
			{{ $product->getProductRemainCount() }}
		</div>

		<h3>
			@lang('remain')
		</h3>
		<p>
			@lang('total remain of product')
		</p>
	</div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="tile-stats">
		<div class="icon">
			<i class="fa fa-exchange"></i>
		</div>
		<div class="count">
			{{ $product->getProductOrderCount() }}
		</div>
		<h3>@lang('new order')</h3>
		<p>
			@lang('total qtyp from new order')
		</p>
	</div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="tile-stats">
		<div class="icon"><i class="fa fa-level-down"></i>
		</div>
		<div class="count">
			{{ $product->getProductImportCount() }}
		</div>
		<h3>@lang('import')</h3>
		<p>
			@lang('total number of import')
		</p>
	</div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
	<div class="tile-stats">
		<div class="icon"><i class="fa fa-level-up"></i>
		</div>
		<div class="count">
			{{ $product->getProductExportCount() }}
		</div>
		<h3>@lang('export')</h3>
		<p>
			@lang('total number of export')
		</p>
	</div>
</div>