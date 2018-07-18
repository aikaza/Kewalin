<div>
	<label class="control-label">
		@lang('export number')
		<span class="required">*</span>
	</label>
	<div class="form-inline">
		<div class="form-group">
			<input type="text" name="export_code" class="form-control" id="order-code" form="form">
		</div>
		<button type="button" class="btn btn-success" style="margin-top: 5px;" id="btn-check-ocode">
			<i class="fa fa-check-square"></i>
			@lang('check')
		</button>
	</div>
	<div id="data-ctn" style="display: none;">
		<br>
		<div id="data-not-found" style="display: none;">
			<label>
				@lang('no result')
			</label>		
		</div>
		<div id="data-found">
			<label class="control-label">
				@lang('result')
			</label>
			<ul>
				<li>
					@lang('product')  => <span id="product-txt"></span>
				</li>
				<li>
					@lang('customer')  => <span id="customer-txt"></span>
				</li>
				<li>
					@lang('color and qty')
					<ul id="color-list">
					</ul>
				</li>
			</ul>
		</div>
		<br>
	</div>

</div>