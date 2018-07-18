@extends('layouts.app')

@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
	<div class="">
		<div class="x_content">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					@include('return.create.title')
					@include('return.create.content')
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /page content -->

@endsection


@section('sc')
<script type="text/javascript">
	
	/**
	* declare variable
	*
	*/
	let data 	= new Data();
	let table   = new InputTableAlt('table');
	table.config = {
		clonedId : 'row-cloned'
	}


	/**
	* initialize suggestion data
	*
	*/
	initSuggestion('exportcode',function(res){
		data.keep('odc_suggestions',res.suggestions);
	});
	initSuggestion('product',function(res){
		data.keep('p_suggestions',res.suggestions);
	});
	initSuggestion('color',function(res){
		data.keep('clr_suggesrtions',res.suggestions);
	});


	$(document).ready(function(){

		
		Autocomplete.add('order-code',data.get('odc_suggestions'),function(suggestion){
			code = suggestion.data;
			checkOrder(code);
		});



		/**
		* add new row function
		* @param  click :event
		* @param  #add-row :id of element
		* @return void
		*
		*/
		(function($){
			table.inst.on('click','#add-row',() => {
				let pcolor_uuid = uuidv4();
				table.addRow();
				table.row = table.lastRow;
				table.row.find('input.p-color').attr('id', pcolor_uuid);
				Autocomplete.add(pcolor_uuid,data.get('clr_suggesrtions'));
				table.focus();
				updateContent();
			});
		})($);





		/**
		* delete row function
		* @param click :event
		* @param .del-btn :class of element
		* @return void
		*
		*/
		(function($){
			table.inst.on('click','.del-btn', e => {
				if(table.rowCount > 1){
					if (confirm("ยืนยันการลบรายการ?")){
						table.thisRow(e.currentTarget).remove();
						updateContent();
					}
				}
			});
		})($);





		/**
		* save and add new row after enter
		* @param keyup :event
		* @param input[type=text] :element 
		* @param e :callback function
		* @return void
		*
		*/
		table.inst.on('click','.save-btn', e => {
			table.row = table.thisRow(e.currentTarget);
			var color_list = data.get('color:list');
			var color_input = table.valueC('p-color');
			var qtyp_input = table.valueC('qtyp');
			if(color_list !== undefined){
				if(color_list[color_input] !== undefined){
					if(parseFloat(qtyp_input) <= parseFloat(color_list[color_input])){
						if ($(e.currentTarget).attr('state') !== 'saved') {
							let pcolor 	= table.valueC('p-color');
							let qtyp 	= table.valueC('qtyp');
							let qtys 	= table.valueC('qtys');
							table.hideC('rf');
							table.textC('txt-p-color',pcolor);
							table.textC('txt-qtyp',number_format(qtyp,2));
							table.textC('txt-qtys',qtys);
							table.showC('rlf');
							table.findC('btn-success').removeClass('btn-success').addClass('btn-link text-primary');
							table.findC('btn-danger').hide();
							$(e.currentTarget).html(`<i class="fa fa-pencil"></i>&ensp;
								{{ __('messages.mn:edit')}}`);
							$(e.currentTarget).attr('state','saved');
						}
						else{
							table.hideC('rlf');
							table.showC('rf');
							table.findC('btn-link.text-primary').removeClass('btn-link text-primary').addClass('btn-success');
							table.findC('btn-danger').show();
							$(e.currentTarget).html(`<i class="fa fa-save"></i>&ensp;{{ __('messages.mn:save')}}`);
							$(e.currentTarget).attr('state','unsaved');
						}
						updateContent();
					}
					else{
						alert('ใส่จำนวนผิด');
					}
				}
				else{
					alert('ไม่พบรหัสสีในรายการ');
				}
			}
			else{
				alert('ไม่พบข้อมูลสินค้า');
			}
		});





		/**
		* save and add new row after enter
		* @param keyup :event
		* @param input[type=text] :element 
		* @param e :callback function
		* @return void
		*
		*/
		(function($){
			table.inst.on('keyup','input[type=text]', e => {
				table.row = table.thisRow($(e.currentTarget));
				let checkEmpty = true;
				if(e.keyCode === 13) {
					try{
						checkEmpty = focusInputEvent(table.row);
					}
					catch(err){
						throw new Error(err);
					}
					finally{
						if(checkEmpty){
							var color_list = data.get('color:list');
							var color_input = table.valueC('p-color');
							var qtyp_input = table.valueC('qtyp');
							if(color_list !== undefined && color_list[color_input] !== undefined && parseFloat(qtyp_input) <= parseFloat(color_list[color_input])){
								table.findC('save-btn').trigger('click');
								table.addBtn.trigger('click');
							}
							else{
								table.findC('save-btn').trigger('click');
							}
						}
					}
				}
			});
		})($);



		/**
		* submit form
		* @param e :callback function
		* @return void
		*
		*/
		(function($){
			$('#btn-check-ocode').click(function(e){
				code = $('#order-code').val();
				checkOrder(code);
			});
		})($);





		/**
		* submit form
		* @param e :callback function
		* @return void
		*
		*/
		table.inst.on('click','.qtys',function(e){

			table.row = table.thisRow($(e.currentTarget));
			let temp_id = uuidv4();
			$(e.currentTarget).attr('id',temp_id);
			$('#modal-tbody').empty();
			$('#modal-detail').attr('toggler',temp_id);
			let str = '';
			let count = Math.ceil(table.valueC('qtyp'));
			if(count > 0){
				count_fraction = (count % 8 === 0) ? 0 : 8 - (count % 8);
				if($(e.currentTarget).val() === 'detail...'){
					for (i = 1; i <= count; i++){
						if (i % 8 === 1){
							str += '<tr>';
						}
						str += '<td>';
						str += '<input type="text" placeholder="#'+i+'" class="form-control input-cell" required>';
						str += '</td>';
						if (i == count && count_fraction != 0){
							str += '<td colspan="'+count_fraction+'"></td>';
						}
						if(i % 8 == 0 || i == count){
							str += '</tr>';
						}
					}
				}
				else{
					let arr_val = $(e.currentTarget).val().split(',');
					for (i = 1; i <= count; i++){
						if (i % 8 === 1){
							str += '<tr>';
						}
						str += '<td>';
						str += '<input type="text" placeholder="#'+i+'" class="form-control input-cell" value="'+arr_val[i-1]+'" required>';
						str += '</td>';
						if (i == count && count_fraction != 0){
							str += '<td colspan="'+count_fraction+'"></td>';
						}
						if(i % 8 == 0 || i == count){
							str += '</tr>';
						}
					}
				}
				$('#modal-tbody').append(str);
				$('#modal-detail').modal('show');
			}
		});

		$('#modal-submit').click(function(){
			let arr = [];
			let empty = false;
			$('#modal-tbody input[type=text]').each(function(index,inst){
				if($(inst).val() === ''){
					empty = true;
					$(inst).focus();
					return false;
				}
			});
			if(!empty){
				$('#modal-tbody input[type=text]').each(function(index,inst){
					arr.push($(inst).val())
				});
				let join_arr = arr.join(',');
				let toggler = $('#modal-detail').attr('toggler');
				$('#'+toggler).val(join_arr);
				$('#'+toggler).closest('td').find('input[type=hidden]').val(join_arr);
				$('#modal-detail').modal('hide');
			}
		});

		$('#modal-default').click(function(){
			let toggler = $('#modal-detail').attr('toggler');
			$('#'+toggler).val('detail...');
			$('#'+toggler).closest('td').find('input[type=hidden]').val('');
			$('#modal-detail').modal('hide');
		});

		$('#btn-submit').click( () => {

			$('#row-cloned').remove();
			$('#form').submit();

		});




		table.addBtn.trigger('click');
	});




totalQtyp = () => {
	let qtyp = 0;
	$('.qtyp').each((key,val) => {
		let value = ($(val).val() === '' || $(val).val() === null) ? 0 : parseFloat($(val).val());
		qtyp += value;
	});
	return qtyp + 0;
}

updateContent = () => {
	let total_list 	= table.rowCount;
	let total_qtyp 	= totalQtyp();
	let total_list_text = "{{__('total n product', ['n' => ':n'])}}";
	$('#total-list').html(total_list_text.replace(':n',total_list));
	$('#total-qtyp').html(smallDecimal(total_qtyp)+0);
}

checkOrder = code => {
	$.ajax({
		url : apiURL('export:get',code),
		type : 'GET',
		dataType : 'json'
	}).done((res) => {
		if(res.length > 0){
			var color_list = {};
			$('#product-txt').text(res[0].product);
			$('#customer-txt').text(res[0].customer);
			$('#unit-text').text(res[0].unit);
			var str = '';
			for (var i = 0; i < res.length; i++) {
				str += '<li>';
				str += res[i].product_color;
				str += '&ensp;';
				str += res[i].qtyp;
				str += '</li>';
				color_list[res[i].product_color] = res[i].qtyp;
			}
			data.keep('color:list',color_list);
			$('#color-list').empty();
			$('#color-list').append(str);
			$('#data-not-found').hide();
			$('#data-found').show();
			$('#data-ctn').show();
		}
		else{
			$('#data-not-found').show();
			$('#data-found').hide();
		}

	}).fail((xhr,status,error) => {
		console.log(status);
	});
}

</script>
@endsection