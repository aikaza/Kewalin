unitChangeEvent = (input_name,output_id,lang = 'th') => {
	$(`input[type=radio][name=${input_name}]`).on('change', function(){
		let unit = $(this).val();
		let text = '';
		if(unit === 'kg'){
			text = (lang === 'th') ? "จำนวน (กิโลกรัม)" : "Quantity (Kilogram)";
		}
		else if(unit === 'y'){
			text = (lang === 'th') ? "จำนวน (หลา)" : "Quantity (Yard)";
		}
		else if(unit === 'm'){
			text = (lang === 'th') ? "จำนวน (เมตร)" : "Quantity (Meter)";
		}
		else{
			text = (lang === 'th') ? "จำนวน (ชิ้น)" : "Quantity (Piece)";
		}
		$(`#${output_id}`).text(text);
	});
}


focusInputEvent = (row_inst) => {
	let result = true;
	$(row_inst).find('input:visible').each( (key,input) => {
		if(!$(input).val()){
			$(input).focus();
			result = false;
			return false;
		}
	});
	return result;
}

initSuggestion = (name,callback) => {
	let url = '';
	if (name === 'customer') 	url = apiURL('sgt:customer');
	if (name === 'product') 	url = apiURL('sgt:product');
	if (name === 'color') 		url = apiURL('sgt:color');
	if (name === 'exportcode') 	url = apiURL('sgt:export:code');
	if (name === 'productcode') 	url = apiURL('sgt:productcode');
	$.ajax({
		url : url,
		type: 'GET',
		dataType : 'json',
		async: false
	}).done(res => {
		callback(res);
	}).fail((xhr,status,error) => {
		console.log("error");
	});
}

class Autocomplete{
	static add(elm_id, data, callback = null){
		$('#'+elm_id).autocomplete({
			lookup : data,
			lookupLimit : 20,
			autoSelectFirst : true,
			onSelect : function(suggestion){
				if(callback !== null){
					callback(suggestion);
				}
			}
		});
	}
}