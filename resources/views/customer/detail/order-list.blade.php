@if ($customer->getCustomerOrderList()->isEmpty())
<p>
@lang('no content available')
</p>
@else
<table class="table">
	<thead>
		<tr>
			<th>#</th>
			<th>@lang('product')</th>
			<th>@lang('number of order (roll)')</th>
			<th>@lang('refcode')</th>
			<th>@lang('date')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($customer->getCustomerOrderList() as $i => $list)
		<tr>
			<td>{{ $i + 1 }}</td>
			<td>
				@foreach (explode(',', $list->product) as $product)
				{{ $product }}<br>
				@endforeach
			</td>
			<td>
				@foreach (explode(',', $list->qtyp) as $qtyp)
				{{ $qtyp+0 }}<br>
				@endforeach
			</td>
			<td>{{ $list->code->code }}</td>
			<td>{{ $list->date }}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endif