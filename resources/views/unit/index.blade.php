@extends('layouts.app')

@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_title">
					<h2>
						@lang('unit')
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
								<th style="width: 15%" rowspan="2">
									@lang('prefix')
								</th>
								<th>
									@lang('thai name')
								</th>
								<th>
									@lang('eng name')
								</th>
								<th class="text-center">
									@lang('action')
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($units as $unit)
							<tr>
								<input type="hidden" name="id" value="{{$unit->id}}">
								<td class="prefix"> {{ $unit->prefix }} </td>
								<td class="name"> {{ $unit->name }} </td>
								<td class="name_eng"> {{ $unit->name_eng }} </td>
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

<div class="modal fade" id="unit-add-modal" role="dialog" tabindex="-1">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">
					@lang('add unit')
				</h4>
			</div>
			<div class="modal-body">
				<form action="{{ route('units.store') }}" method="POST" id="add-form">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="usr">
							@lang('prefix')
						</label>
						<input type="text" name="prefix" class="form-control" placeholder="eg. kg for kilogram" required>
					</div>
					<div class="form-group">
						<label for="pwd">
							@lang('thai name')
						</label>
						<input type="text" name="name" class="form-control" placeholder="eg. กิโลกรัม" required>
					</div>
					<div class="form-group">
						<label for="pwd">
							@lang('eng name')
						</label>
						<input type="text" name="name_eng" class="form-control" placeholder="eg. kilogram" required>
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
<div class="modal fade" id="unit-edit-modal" role="dialog" tabindex="-1">
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
				<form action="{{ route('units.update') }}" method="POST" id="edit-form">
					{{ csrf_field() }}
					{{ method_field('put') }}
					<input type="hidden" name="id">
					<div class="form-group">
						<label for="usr">
							@lang('messages.unit:prefix')
						</label>
						<input type="text" name="prefix" class="form-control" placeholder="eg. kg for kilogram" required>
					</div>
					<div class="form-group">
						<label for="pwd">
							@lang('messages.unit:name')
						</label>
						<input type="text" name="name" class="form-control" placeholder="eg. กิโลกรัม" required>
					</div>
					<div class="form-group">
						<label for="pwd">
							@lang('messages.unit:name_eng')
						</label>
						<input type="text" name="name_eng" class="form-control" placeholder="eg. kilogram" required>
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
		$('#unit-add-modal').modal('show');
	});

	$('.edit').click(function(){
		tr = $(this).closest('tr');
		id = $(tr).find('input[name=id]').val();
		prefix = $(tr).find('.prefix').text().trim();
		name = $(tr).find('.name').text().trim();
		name_eng = $(tr).find('.name_eng').text().trim();
		$('#edit-form input[name=id]').val(id);
		$('#edit-form input[name=prefix]').val(prefix);
		$('#edit-form input[name=name]').val(name);
		$('#edit-form input[name=name_eng]').val(name_eng);
		$('#unit-edit-modal').modal('show');
	});

</script>
@endsection