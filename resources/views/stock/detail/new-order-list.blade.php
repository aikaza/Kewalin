<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
	@if ($product->getProductOrderList()->isEmpty())
	<p>
		@lang('no content available')
	</p>
	@else
	<table class="table">
		<thead>
			<tr>
				<th>
					#
				</th>
				<th>
					@lang('color')
				</th>
				<th>
					@lang('number of order (roll)')
				</th>
				<th>
					@lang('customer')
				</th>
				<th>
					@lang('order number')
				</th>
				<th>
					@lang('date')
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($product->getProductOrderList() as $i => $list)
			<tr>
				<td>
					{{ $i + 1 }}
				</td>
				<td>
					{{ $list->product_color }}
				</td>
				<td>
					{{ $list->qtyp }}
				</td>
				<td>
					{{ $list->customer->first_name }}
					{{ $list->customer->last_name }}
				</td>
				<td>
					{{ $list->code->code }}
				</td>
				<td>
					{{ $list->date }}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@endif
</div>