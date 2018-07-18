
class Product{


	static getCode(str){
		let input = str.split('|');
		let product_code = input[0].replace('#','').trim();
		return product_code;
	}

	static check(str){
		let code = this.getCode(str);
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

}