@extends('layouts.app')

@section('content')
<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="row">
			<form class="form-group" action="{{ route('config.update') }}" method="POST">
				{{ csrf_field() }}
				{{ method_field('put') }}
				@foreach ($config as $c)
				@if ($c->key === 'cripoint')
				<div>
					<label>Critical point</label>
					<input type="number" name="config[cripoint]" 
					value="{{ $c->value }}">	
				</div>
				@elseif($c->key === 'outdatedr')
				<div>
					<label>Outdate duration</label>
					<input type="number" name="config[outdatedr]" 
					value="{{ $c->value }}">	
				</div>
				@endif
				@endforeach
				<input type="submit">
			</form>
		</div>
	</div>
</div>
@endsection