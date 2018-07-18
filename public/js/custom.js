function getElmById(id){
	return $(`#${id}`);
}

function replaceClass(ob, oldState, newState){
	$(ob).removeClass(oldState).addClass(newState);
}

function number_format (number, decimals, dec_point, thousands_sep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number,
	prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	s = '',
	toFixedFix = function (n, prec) {
		var k = Math.pow(10, prec);
		return '' + Math.round(n * k) / k;
	};
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
	}
	return s.join(dec);
}

function uuidv4() {
	return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
		(c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
		)
}


function once(fn, context) { 
	var result;

	return function() { 
		if(fn) {
			result = fn.apply(context || this, arguments);
			fn = null;
		}

		return result;
	};
}

getProductCode = str => {
	let input = str.split('|');
	product_code = input[0].replace('#','').trim();
	return product_code;
}

checkProduct = code => {
	let response = null;
	$.ajax({
		url: apiURL('product:check',code),
		method: 'GET',
		dataType: 'json',
		async: false
	}).done(res => {
		response = res;
	}).fail( (xhr,status,error) => {
		console.log(JSON.parse(xhr.responseText));
	});
	return response;
}

smallDecimal = (number) => {
	let format_number = number_format(number,2);
	let decimal_number = format_number.slice(-2);
	let result = format_number.slice(0,-2) + `<small>${decimal_number}</small>`;
	return result;
}