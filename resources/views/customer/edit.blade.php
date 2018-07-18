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
								<li><a href="{{ route('customers.index') }}">
									@lang('customer')
								</a></li>
								<li class="active">
									@lang('update customer')
								</li>
							</ul>
						</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<br />
						<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{ route('customers.update',$ct->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT')}}
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">@lang('first name') <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name="first_name" class="form-control col-md-7 col-xs-12" value="{{ $ct->first_name }}" required>
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last_name">@lang('last name')
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name="last_name" class="form-control col-md-7 col-xs-12" value="{{ $ct->last_name }}">
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="alias_name">@lang('alias name')
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="text" name="alias_name" class="form-control col-md-7 col-xs-12" data-validate-length-range="4" value="{{ $ct->alias_name }}" >
								</div>
							</div>
							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">@lang('phone number') <span class="required">*</span>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="tel" name="phone_no" class="form-control col-md-7 col-xs-12" value="{{ $ct->phone_no }}"  required>
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">@lang('email')
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<input type="email" name="email" class="form-control col-md-7 col-xs-12" value="{{ $ct->email }}">
								</div>
							</div>

							<div class="item form-group">
								<label class="control-label col-md-3 col-sm-3 col-xs-12 " for="first-name">@lang('address')
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<textarea rows="2" name="address" class="form-control col-md-7 col-xs-12">{{ $ct->address }}</textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
									<button type="submit" class="btn btn-primary btn-block" name="add_customer">@lang('save')</button>
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
		$('input,textarea').keyup(function(){
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