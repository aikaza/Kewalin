@extends('layouts.app')

@section('content')


<div class="modal fade" id="modal" role="dialog" tabindex="-1">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">
					ชำระรายการบิล
				</h4>
			</div>
			<div class="modal-body">
				<form action="{{ route('debt.paid') }}" method="POST" id="add-form">
					{{ csrf_field() }}
					<input type="hidden" name="code_id">
					<div class="form-group">
						<label for="usr">
							ธนาคาร
						</label>
						<input type="text" id="bank" name="bank" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="pwd">
							หมายเลขเช็ค/บัญชี
						</label>
						<input type="text" name="cheque_number" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="pwd">
							วันที่โอน
						</label>
						<input type="text" name="issue_date" class="form-control" value="{{ date('Y/m/d')}}">
					</div>
					<div class="form-group">
						<label for="pwd">
							หมายเหตุ
						</label>
						<textarea name="note" class="form-control" rows="2"></textarea>
					</div>	
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" form="add-form">
					<i class="fa fa-save"></i>
					@lang('messages.mn:save')
				</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">
					<i class="fa fa-close"></i>
					@lang('messages.mn:close')
				</button>
			</div>
		</div>

	</div>
</div>



<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_title">
					<h2>
						<ul class="breadcrumb" style="padding: 0;background-color: transparent;margin: 0">
							<li>
								<a href="{{ route('invoices.index') }}">
									@lang('debt')
								</a>
							</li>
							<li class="active">
								@lang('detail')
								<small>
									{{ $customer->first_name }}
									{{ $customer->last_name }}
								</small>
							</li>
						</ul>
					</h2>
					<ul class="nav navbar-right panel_toolbox">
						<li>
							<select class="form-control input-sm" id="filter">
								<option value="all">ทั้งหมด</option>
								<option value="pending" selected>ค้างชำระ</option>
								<option value="paid">ชำระแล้ว</option>
							</select>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<table class="table table-striped table-bordered jambo_table" id="table">
						<thead>
							<tr>
								<th>#</th>
								<th>@lang('bill number')</th>
								<th>@lang('total')</th>
								<th>@lang('date')</th>
								<th>@lang('status')</th>
								<th class="text-center">@lang('action')</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->
@endsection

@section('sc')
<script type="text/javascript">
	
	let datatable = null;
	let status = 'pending';

	$(document).ready(function(){

		let banks = [
		{ value:'ธ.กรุงเทพ', data:'ธ.กรุงเทพ' },
		{ value:'ธ.กรุงไทย', data:'ธ.กรุงไทย' },
		{ value:'ธ.กรุงศรีอยุธยา', data:'ธ.กรุงศรีอยุธยา' },
		{ value:'ธ.กสิกรไทย', data:'ธ.กสิกรไทย' },
		{ value:'ธ.เกียรตินาคิน', data:'ธ.เกียรตินาคิน' },
		{ value:'ธ.ซีไอเอ็มบี ไทย', data:'ธ.ซีไอเอ็มบี ไทย' },
		{ value:'ธ.ไทยเครดิต เพื่อรายย่อย', data:'ธ.ไทยเครดิต เพื่อรายย่อย' },
		{ value:'ธ.ทิสโก้', data:'ธ.ทิสโก้' },
		{ value:'ธ.ไทยพาณิชย์', data:'ธ.ไทยพาณิชย์' },
		{ value:'ธ.ธนชาต', data:'ธ.ธนชาต' },
		{ value:'ธ.ยูโอบี', data:'ธ.ยูโอบี' },
		{ value:'ธ.แลนด์ แอนด์ เฮ้าส์', data:'ธ.แลนด์ แอนด์ เฮ้าส์' },
		{ value:'ธ.สแตนดาร์ดชาร์เตอร์ด', data:'ธ.สแตนดาร์ดชาร์เตอร์ด' },
		{ value:'ธ.ไอซีบีซี', data:'ธ.ไอซีบีซี' },
		{ value:'ธ.สถาบันการเงินเฉพาะกิจ', data:'ธ.สถาบันการเงินเฉพาะกิจ' },
		{ value:'ธ.เพื่อการเกษตรและสหกรณ์การเกษตร', data:'ธ.เพื่อการเกษตรและสหกรณ์การเกษตร' },
		{ value:'ธ.เพื่อการส่งออกและนำเข้าแห่งประเทศไทย', data:'ธ.เพื่อการส่งออกและนำเข้าแห่งประเทศไทย' },
		{ value:'ธ.ออมสิน', data:'ธ.ออมสิน' },
		{ value:'ธ.อิสลามแห่งประเทศไทย', data:'ธ.อิสลามแห่งประเทศไทย' },
		{ value:'ธ.อาคารสงเคราะห์', data:'ธ.อาคารสงเคราะห์' } ];

		$('#bank').autocomplete({
			lookup : banks,
			autoSelectFirst : true
		});

		$(document).on('click', '.paid',function(){
			let bill_number = $(this).closest('tr').find('.code').text();
			let total = $(this).closest('tr').find('.total').text();
			let code_id = $(this).attr('cid');
			$('input[name=code_id]').val(code_id);
			$('#modal .modal-title').text('ชำระรายการบิล ' + bill_number + ' จำนวน ' + total + 'บาท');
			$('#modal').modal('show');
		});

		$('#filter').on('change', function(){
			status = $(this).val();
			updateDataTable();
		});

		updateDataTable();

	});

	var updateDataTable = () => {
		(datatable === null ) ? {} : datatable.destroy();
		datatable = $('#table').DataTable({
			processing : true,
			serverSide : true,
			ajax : {
				url : apiURL('dt:debt:list',{{ $customer->id }}),
				type : 'GET',
				data : {
					status : status
				}
			},
			columns : [
			{ data : 'DT_Row_Index', name : 'DT_Row_Index', class : 'text-center' },
			{ data : 'bill_number', name : 'bil_number', class : 'code'},
			{ data : 'total', name : 'total', class: 'total'},
			{ data : 'date' , name : 'date'},
			{ data : 'status', name : 'status'},
			{ data : 'action', name : 'action', class : 'text-center'}
			]
		}); 
	}
	

</script>
@endsection



