<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_content">
			<div class="" role="tabpanel" data-example-id="togglable-tabs">
				<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">
							<i class="fa fa-bitbucket"></i>
							@lang('product remain')
						</a>
					</li>
					<li role="presentation">
						<a href="#tab_content2" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">
							<i class="fa fa-exchange"></i>
							@lang('new order')
						</a>
					</li>
					<li role="presentation">
						<a href="#tab_content3" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">
							<i class="fa fa-level-down"></i>
							@lang('newest importing')
						</a>
					</li>
					<li role="presentation">
						<a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">
							<i class="fa fa-level-up"></i>
							@lang('newest exporting')
						</a>
					</li>
				</ul>
				<div id="myTabContent" class="tab-content">
					@include('stock.detail.remain-list')
					@include('stock.detail.new-order-list')
					@include('stock.detail.importing-list')
					@include('stock.detail.exporting-list')
				</div>
			</div>
		</div>
	</div>
</div>