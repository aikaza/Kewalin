<table class="list-table" style="margin-bottom: 16px">
	<tbody>
		<tr>
			<td>
				@lang('name') 
			</td>
			<td>
				{{ $name }}
			</td>
		</tr>
		<tr>
			<td>
				@lang('alias name') 
			</td>
			<td>
				{{ $alias_name }}
			</td>
		</tr>
		<tr>
			<td>
				@lang('address') 
			</td>
			<td>
				{{ $address }}
			</td>
		</tr>
		<tr>
			<td>
				@lang('phone number') 
			</td>
			<td>
				{{ $phone_no }}
			</td>
		</tr>
		<tr>
			<td>
				@lang('email') 
			</td>
			<td>
				{{ $email }}
			</td>
		</tr>
		@if (!empty($refcode))
		<tr>
			<td>
				@lang('refcode') 
			</td>
			<td>
				{{ $refcode }}
				<a href="{{ route('exports.create',['refcode' => $refcode, 'pattern' => $pattern]) }}" class="float-right">{{ $export_text }} </a>
			</td>
		</tr>
		@endif
		@if (!empty($onlyrefcode))
		<tr>
			<td>
				@lang('refcode') 
			</td>
			<td>
				{{ $onlyrefcode }}
			</td>
		</tr>
		@endif
	</tbody>
</table>