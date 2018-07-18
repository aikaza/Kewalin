<div class="x_content">
	<br />
	<form method="POST" action="{{ route('returns.store') }}" id="form">
		{{ csrf_field() }}
	</form>
	@include('return.create.modal-detail')
	@include('return.create.order-code-check')
	@include('return.create.row')
	@include('return.create.input-table')
	<div class="form-group">
		<button type="button" class="btn btn-success" id="btn-submit">
			<i class="fa fa-check-circle"></i> เสร็จสิ้น
		</button>
	</div>
</div>