@extends('layouts.app')
@include('class.user-class')
@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_title">
					<h2>
						@lang('member')
					</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<button class="btn btn-success input-sm" id="add-btn">
								<i class="fa fa-plus"></i>
								@lang('new record')
							</button>
						</li>
						<li>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table id="p-table" class="table table-striped table-bordered jambo_table full-width hoveron">
						<thead>
							<tr>
								<th>
									#
								</th>
								<th>
									@lang('name')
								</th>
								<th>
									@lang('username')
								</th>
								<th>
									@lang('role')
								</th>
								<th class="text-center">
									@lang('action')
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($users as $index => $user)
							<tr>
								<input type="hidden" name="id" value="{{$user->id}}">
								<td>
									{{ $index +1 }}
								</td>
								<td class="name"> 
									{{ $user->name }}
								</td>
								<td class="username">
									{{ $user->username }}
								</td>
								<td class="role" data="{{$user->role}}">
									{{ User::getRole($user->role) }}
								</td>
								<td class="text-center"> 
									<a href="#" class="text-primary edit">
										@lang('edit')
									</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="user-add-modal" role="dialog" tabindex="-1">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">
					@lang('add member')
				</h4>
			</div>
			<div class="modal-body">
				<form action="{{ route('users.store') }}" method="POST" id="add-form">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="usr">
							@lang('name')
						</label>
						<input type="text" name="name" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="pwd">
							@lang('username')
						</label>
						<input type="text" name="username" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="pwd">
							@lang('password')
						</label>
						<input type="password" name="password" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="pwd">
							@lang('role')
						</label>
						<select class="form-control" name="role">
							<option value="rsb" selected>ฝ่ายจัดซื้อ</option>
							<option value="acm">ฝ่ายบัญชี</option>
							<option value="ext_major">ฝ่ายส่งสินค้า (หน้าร้าน)</option>
							<option value="ext_minor">ฝ่ายส่งสินค้า (โกดัง)</option>
						</select>
					</div>	
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" form="add-form">
					<i class="fa fa-save"></i>
					@lang('save')
				</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fa fa-close"></i>
					@lang('close')
				</button>
			</div>
		</div>

	</div>
</div>
<div class="modal fade" id="user-edit-modal" role="dialog" tabindex="-1">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">
					@lang('messages.unit:edit')
				</h4>
			</div>
			<div class="modal-body">
				<form method="POST" id="edit-form">
					{{ csrf_field() }}
					{{ method_field('put') }}
					<input type="hidden" name="id">
					<div class="form-group">
						<label for="usr">
							ชื่อ
						</label>
						<input type="text" name="name" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="pwd">
							ชื่อผู้ใช้
						</label>
						<input type="text" name="username" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="pwd">
							บทบาท
						</label>
						<select class="form-control" name="role">
							<option value="rsb">ฝ่ายจัดซื้อ</option>
							<option value="acm">ฝ่ายบัญชี</option>
							<option value="ext_major">ฝ่ายส่งสินค้า</option>
							<option value="ext_minor">ฝ่ายส่งสินค้า (โกดัง)</option>
						</select>
					</div>	
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" form="edit-form">
					<i class="fa fa-save"></i>
					@lang('messages.mn:edit')
				</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fa fa-close"></i>
					@lang('messages.mn:close')
				</button>
			</div>
		</div>

	</div>
</div>

<!-- /page content -->
@endsection

@section('sc')
<script type="text/javascript">
	$('#add-btn').click(() => {
		$('#user-add-modal').modal('show');
	});

	$('.edit').click(function(){
		tr = $(this).closest('tr');
		id = $(tr).find('input[name=id]').val();
		$('#edit-form').attr('action','/users/'+id);
		name = $(tr).find('.name').text().trim();
		username = $(tr).find('.username').text().trim();
		role = $(tr).find('.role').attr('data').trim();
		$('#edit-form input[name=id]').val(id);
		$('#edit-form input[name=name]').val(name);
		$('#edit-form input[name=username]').val(username);
		$('#edit-form select[name=role]').find('option[value='+role+']').prop('selected',true);
		$('#user-edit-modal').modal('show');
	});

</script>
@endsection