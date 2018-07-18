<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
	@if ($product->getProductImportList()->isEmpty())
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
					@lang('qty :param',['param' => __('roll')])
				</th>
				<th>
					@lang('qty :param',['param' => __('2ry')])
				</th>
				<th>
					@lang('import price')
				</th>
				<th>
					@lang('lot number')
				</th>
				<th>
					@lang('date')
				</th>
				<th>
					@lang('issue by')
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($product->getProductImportList() as $i => $list)
			<tr>
				<td>
					{{ $i + 1 }}
				</td>
				<td>
					{{ $list->product_color }}
				</td>
				<td>
					{{ number_format($list->qtyp) }}
				</td>
				<td>
					{{ number_format($list->qtys) }}
					{{ unitName($list->unit_id) }}
				</td>
				<td>&#3647; 
					{{ number_format($list->cost_per_unit) }}
				</td>
				<td>
					{{$list->lot_number}}
				</td>
				<td>
					{{ $list->date }}
				</td>
				<td>
					{{ $list->user->name }}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<a href="{{ route('stocks.import.list',$pd->id) }}">
		ดูรายการนำเข้าทั้งหมด
	</a>
	@endif
</div>