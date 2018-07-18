
<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
	@if ($product->getProductRemainList()->isEmpty())
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
					@lang('lot number')
				</th>
				<th>
					@lang('qty :param',['param' => __('roll')])
				</th>
				<th>
					@lang('last update')
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($product->getProductRemainList() as $i => $list)
			<tr>
				<td>
					{{ $i + 1 }}
				</td>
				<td>
					<a href="{{ route('stocks.product.lot.detail',['product_id'=>$pd->id,'lot_number'=>$list->lot_number]) }}">
						<code>
							{{ $list->lot_number }}
						</code>
					</a>
				</td>
				<td>
					{{ number_format($list->qtyp) }}
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