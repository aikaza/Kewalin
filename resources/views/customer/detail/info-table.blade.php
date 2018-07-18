
<table class="list-table">
	<tbody>
		<tr>
			<td>
				@lang('name')
			</td>
			<td>
				{{ $ct->first_name }} {{ $ct->last_name }}
			</td>
		</tr>
		<tr>
			<td>
				@lang('alias name')
			</td>
			<td>
				{{ $ct->alias_name }}
			</td>
		</tr>
		<tr>
			<td>
				@lang('phone number')
			</td>
			<td>
				{{ $ct->phone_no }}
			</td>
		</tr>
		<tr>
			<td>
				@lang('email')
			</td>
			<td>
				{{ $ct->email }}
			</td>
		</tr>
		<tr>
			<td>
				@lang('address')
			</td>
			<td>
				{{ $ct->address }}
			</td>
		</tr>
	</tbody>
</table>
