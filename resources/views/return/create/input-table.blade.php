<div class="form-group">
	<table class="table table-striped table-bordered input-table jambo_table" id="table">
		<thead>
			<tr>
				<th class="wth20" rowspan="2">
					# @lang('color')
				</th>	
				<th colspan="4">
					@lang('unit') <span id="unit-text"></span>
				</th>
			</tr>
			<tr>
				<th class="wth20">
					@lang('qty :param', ['param' => __('roll')])
				</th>
				<th>
					@lang('add detail')
				</th>
				<th width="18%" class="text-center" colspan="2">
					@lang('action')
				</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
		<tfoot>
			<tr id="sumary">
				<th id="total-list">
					@lang('total n product',['n' => '1'])
				</th>
				<th colspan="2">
					<span id="total-qtyp">0</span>
				</th>
				<th colspan="2">
					<button class="btn btn-default btn-block" id="add-row">
						<i class="fa fa-plus-circle"></i> @lang('add row')
					</button>
				</th>
			</tr>
		</tfoot>
	</table>
</div>