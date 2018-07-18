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
									@lang('add product')
								</li>
							</ul>
						</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" method="POST" action="{{ route('products.store') }}">
							{{ csrf_field() }}
							<div class="form-group {{ $errors->has('product_code') ? 'has-error' :'' }}">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									@lang('product code')
									<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" class="form-control col-md-7 col-xs-12" name="product_code" value="{{old('product_code')}}" required>
								</div>
							</div>
							<div class="form-group {{ $errors->has('product_name') ? 'has-error' :'' }}">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									@lang('product name') 
									<span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" class="form-control col-md-7 col-xs-12" name="product_name"  value="{{old('product_name')}}" required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
									@lang('image')
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<span class="btn btn-default btn-file">
										<input type="file" name="fileUpload[]" multiple="multiple" accept="image/*" onchange="readURL(this)">
									</span>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" id="preview-img">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<button type="submit" class="btn btn-success btn-block">
										@lang('add')
									</button>
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


	function readURL(input) {
		$('#preview-img').empty();
		if (input.files) {
			$(input.files).each((key, file) => {
				var reader = new FileReader();
				reader.onload = function(e) {
					let img = document.createElement('img');
					$(img).attr('src',e.target.result);
					$(img).attr('alt','your image');
					$(img).addClass('auto-fit');
					$('#preview-img').append(img);
				}
				reader.readAsDataURL(file);
			});
		}
	}
</script>

@endsection