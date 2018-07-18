@extends('layouts.app')
@section('php')
@php

$customer = cInfo($ex[0]->order->customer_id); 
$customer_data = [
	'name' => $customer->first_name.' '.$customer->last_name,
	'alias_name' => $customer->alias_name,
	'address' => $customer->address,
	'phone_no' => $customer->phone_no,
	'email' => $customer->email,
	'onlyrefcode' => $ex[0]->order->code_id
];
$qtyp = 0;
$qtys = 0;
@endphp
@endsection
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
                                    <a href="{{ route('orders.index') }}">
                                        @lang('export')
                                    </a>
                                </li>
                                <li class="active">
                                    @lang('insert price')
                                    <small>
                                        {{ $customer->first_name }}
										{{ $customer->last_name }}
                                    </small>
                                </li>
                            </ul>
                        </h2>
                        <div class="clearfix">
                        </div>
                    </div>
                    <div class="x_content">
                        <br/>
                        <form action="{{ route('exports.insert.price') }}" id="add_form" method="POST">
                            {{ csrf_field() }}
							{{ method_field('put') }}
                            <input name="ordercode" type="hidden" value="{{ $code_id }}">
                            </input>
                        </form>
                        @include('custom.customer-info',$customer_data)
                        <div class="form-group">
                            <table class="table table-bordered table-cell jambo_table jambo_border" id="input-table">
                                <thead>
                                    <tr>
                                        <th class="text-center" rowspan="2" style="vertical-align: middle;width: 20%;">
                                            # @lang('product code')
                                        </th>
                                        <th colspan="3" id="sunit">
                                            @lang('unit')
										{{ unitName($ex[0]->unit_id) }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            @lang('qty :param',['param' => __('roll')])
                                        </th>
                                        <th>
                                            @lang('qty :param',['param'=>unitName($ex[0]->unit_id)])
                                        </th>
                                        <th>
                                            @lang('price')/{{ unitName($ex[0]->unit_id) }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ex as $i => $e)
                                    <input form="add_form" name="id[]" type="hidden" value="{{$e->id}}">
                                        <input form="add_form" name="qtys[]" type="hidden" value="{{$e->qtys}}">
                                            @php
								$qtyp += $e->order->qtyp;
								$qtys += $e->qtys;
								@endphp
                                            <tr>
                                                <td style="padding-left: 16px !important;">
                                                   #{{ $e->order->product->code }} &bull; {{ $e->order->product_color }}
                                                </td>
                                                <td style="padding-left: 16px !important;">
                                                    {{ number_format($e->order->qtyp,2) }}
                                                </td>
                                                <td class="qtys" style="padding-left: 16px !important;">
                                                    {{number_format($e->qtys,2) }}
                                                </td>
                                                <td>
                                                    <input class="form-control input-cell price-input" form="add_form" name="price[]" placeholder="{{__('price')}}" required="" type="text">
                                                    </input>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </input>
                                    </input>
                                </tbody>
                                <tfoot>
                                    <tr style="background-color: rgba(52,73,94,.94);color: #ECF0F1;border: 2px solid rgba(52, 73, 94, 0.94) !important;">
                                        <th style="padding-left: 16px !important;">
                                            @lang('total n product',['n' => sizeof($ex)])
                                        </th>
                                        <th style="padding-left: 16px !important;">
                                            {{ number_format($qtyp,2) }}
                                        </th>
                                        <th style="padding-left: 16px !important;">
                                            {{ number_format($qtys,2)  }}
                                        </th>
                                        <th id="total-price">
                                            ฿ 0.00
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" form="add_form" id="submit-btn" type="submit">
                                <i class="fa fa-check-circle">
                                </i>
                                เสร็จสิ้น
                            </button>
                        </div>
                        <!-- </form>  -->
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
    $(document).ready(() => {
		$('.price-input').keyup(function(){
			var arr = $.map($('.price-input'), function (el) { 
                qtys = $(el).closest('tr').find('.qtys').text().trim();
                qtys = qtys.replace(/\,/g,''); 
				return (el.value === '') ? 0 : el.value * parseFloat(qtys); 
			});
			arr = arr.filter(function(v){ return v !== '' });
			if(arr.length > 0){
				var sum = arr.reduce((accumulator, value) => { return accumulator + parseFloat(value) },0);
				$('#total-price').html('\u0E3F '+number_format(sum,2));
			}
			else{
				$('#total-price').html('\u0E3F '+number_format(0,2));
			}
		});
	});
</script>
@endsection
