<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_content">
			<div class="" role="tabpanel" data-example-id="togglable-tabs">
				<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">
							<i class="fa fa-user"></i>
							@lang('customer info')
						</a>
					</li>
					<li role="presentation">
						<a href="#tab_content2" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">
							<i class="fa fa-exchange"></i>
							@lang('lastest order list')
						</a>
					</li>
				</ul>
				<div id="myTabContent" class="tab-content">
					<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
						@include('customer.detail.info-table')
					</div>
					<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="home-tab">
						@include('customer.detail.order-list')
					</div>
				</div>
			</div>
		</div>
	</div>
</div>