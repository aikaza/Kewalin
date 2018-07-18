@extends('layouts.app')

@section('content')

<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="x_content" style="padding: 36px 25%">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_title">
						<h2>
							ลบลูกค้า #{{$ct->id}} {{$ct->first_name}} {{$ct->last_name}}
						</h2>
						<div class="clearfix"></div>
					</div>
					<p class="text-danger" style="font-size: 16px">
						<strong>
							Attention!
						</strong> 
						These associated data will be deleted all permanently. It may affect the statistic information. So, make sure you really mean to do it.	
					</p>
					<table class="table">
						<thead>
							<tr>
								<th>
									Associated Data
								</th>
								<th>
									Number of Record(s)
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style="padding-top: 8px">
									Export Data 
								</td>
								<td style="padding-top: 8px">
									{{ $export_data_count }}
								</td>
							</tr>
							<tr>
								<td style="padding-top: 8px">
									Order Data
								</td>
								<td style="padding-top: 8px">
									{{ $order_data_count }}
								</td>
							</tr>
							<tr>
								<td style="padding-top: 8px">
									Debt Data
								</td>
								<td style="padding-top: 8px">
									{{ $debt_data_count }}
								</td>
							</tr>
						</tbody>
					</table>
					<form style="margin-top: 16px" action="{{ route('customers.destroy',$ct->id) }}" method="POST" onsubmit="return confirm('หากคุณลบรายการแล้ว จะไม่สามารถกู้คืนได้ ยืนยันทำต่อ?')">
						{{ csrf_field() }}
						{{ method_field('delete') }}
						<div class="form-group">
							<label for="email">Enter : <code>delete this customer #{{$ct->id}}</code></label>
							<input type="text" class="form-control" id="confirm-input" placeholder="Enter confirm text" name="confirm_delete" autocomplete="off">
						</div>
						<button type="submit" class="btn btn-secondary btn-block" disabled id="submit-btn">Delete
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('sc')

<script type="text/javascript">
	$(document).ready(()=>{
		$('#confirm-input').keyup(function(){
			if($(this).val() === 'delete this customer #{{$ct->id}}'){
				$('#submit-btn').removeClass('btn-secondary').addClass('btn-danger');
				$('#submit-btn').prop('disabled',false);
			}else{
				$('#submit-btn').removeClass('btn-danger').addClass('btn-secondary');
				$('#submit-btn').prop('disabled',true);
			}
		});
	});
</script>

@endsection