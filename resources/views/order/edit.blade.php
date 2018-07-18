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
                                    <a href="{{ route('orders.index') }}">
                                        @lang('order')
                                    </a>
                                </li>
                                <li class="active">
                                    @lang('edit') 
                                    <small>
                                        {{ $code }}
                                    </small>
                                </li>
                            </ul>
                        </h2>
                        <div class="clearfix">
                        </div>
                    </div>
                    <div class="x_content">
                        <br/>
                        <form action="{{ route('orders.update',$code) }}" id="add_form" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <input type="hidden" name="order_number" value="{{ $code }}">
                        </form>
                        <div class="form-group">
                            <table class="table table-striped table-bordered input-table jambo_table" id="order-add-table">
                                <thead>
                                    <tr>
                                        <th rowspan="2">
                                            # @lang('product code')
                                        </th>
                                        <th rowspan="2" width="20%">
                                            # @lang('product color')
                                        </th>
                                        <th colspan="3">
                                            @lang('detail')
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            @lang('qty :param',['param'=>__('roll')])
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                    <tr>
                                        <input type="hidden" name="order_id[]" value="{{ $d->id }}" form="add_form">
                                        <td>
                                            <input class="form-control product" form="add_form" name="product_code[]" required="required" type="text" value="{{$d->product->code}}">
                                            </input>
                                        </td>
                                        <td>
                                            <input class="form-control color" form="add_form" name="product_color[]" required="required" type="text" value="{{ $d->product_color }}">
                                            </input>
                                        </td>
                                        <td>
                                            <input class="form-control qtyp" form="add_form" min="0" name="product_qtyp[]" required="required" type="text" value="{{ $d->qtyp }}">
                                            </input>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr id="sumary">
                                        <th colspan="3">
                                            @lang('total')
                                            <span id="total-list">
                                                {{ count($data) }}
                                            </span>
                                            @lang('product')
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" form="add_form" id="submit-btn" type="submit">
                                <i class="fa fa-check-circle">
                                </i>
                                Submit
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
    //declare global variable
	let data = new Data();
	let add_btn  	= getElmById('add-row');
	let table       = new InputTable('order-add-table');
	let table_conf  = table.config = {
		cloneRow : 1,
		text : {
			event : 'rowFixed',
			value : 'last',
			in : 'tfoot'
		}
	}
	
	initSuggestion('productcode',function(res){
		data.keep('p_suggestions',res.suggestions);
	});
	initSuggestion('color',function(res){
		data.keep('clr_suggesrtions',res.suggestions);
	});



	$(document).ready(function(){


	$('.product').each(function(){
		$(this).autocomplete({
		lookup : data.get('p_suggestions'),
		lookupLimit : 20,
		autoSelectFirst : true
		});
	});

	$('.color').each(function(){
		$(this).autocomplete({
		lookup : data.get('clr_suggesrtions'),
		lookupLimit : 20,
		autoSelectFirst : true
		});
	});



	updateContent = () => {
		let total_list = table.rowCount;
		let total_qtyp = totalQtyp();
		$('#total-list').text(total_list);
		$('#total-qtyp').text(number_format(total_qtyp,2));
	}

	checkColor = color => {
		var response = null;
		$.ajax({
			url: apiURL('color:check',color),
			method: 'GET',
			dataType: 'json',
			async: false
		}).done( res => {
			response = res;
		}).fail((xhr,status,error) =>{
			console.log(JSON.parse(xhr.responseText));
		});
		return response;
	}
});
</script>
@endsection
