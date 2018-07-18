@extends('layouts.app')

@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="x_content">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_title">
						<h2>
							<ul class="breadcrumb" style="padding: 0;background-color: transparent;margin: 0">
								<li>
									<a href="{{ route('products.index') }}">
										@lang('product')
									</a>
								</li>
								<li class="active">
									@lang('update product')
								</li>
							</ul>
						</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form  method="POST" action="{{ route('products.update',$pd->id) }}" data-parsley-validate class="form-horizontal form-label-left">
							{{ csrf_field() }}
							{{ method_field('put') }}
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									@lang('product number')
									<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" class="form-control col-md-7 col-xs-12" value="{{$pd->id}}" name="product_id" required readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									@lang('product code')
									<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" class="form-control col-md-7 col-xs-12" value="{{$pd->code}}" name="product_code" placeholder="eg. ST160001" required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									@lang('product name') <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" class="form-control col-md-7 col-xs-12" value="{{ $pd->name}}" name="product_name" required>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
									<button type="submit" class="btn btn-primary btn-block">@lang('save')</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->

@endsection

@section('sc')

<script type="text/javascript">

	$(document).ready(function(){
		$('input').keyup(function(){
			if($(this).is(':valid')){
				$(this).closest('.form-group').addClass('has-success').removeClass('has-error');
			}
			else{
				$(this).closest('.form-group').addClass('has-error').removeClass('has-success');
			}
		});
	});


</script>

@endsection