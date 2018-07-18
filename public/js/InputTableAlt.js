class InputTableAlt{

	constructor(id){
		this._id = id;
		this._inst = getElmById(id);
		this._row = null;
		this._config = {};
	}

	set config(arg){ this._config = arg }
	set row(row){ this._row = row }
	get row(){ return this._row }
	get inst(){ return this._inst }
	get firstRow(){ return $(`#${this._id} > tbody > tr:first`) }
	get lastRow(){ return $(`#${this._id} > tbody > tr:last`) }
	get rowCount() {
		let rowCount = $(`#${this._id} > tbody`).children().length;
		return rowCount;
	}

	rowAt(i){
		if(i < 0){
			i = Math.abs(i);
			return $(`#${this._id} > tbody > tr:nth-last-child(${i})`);
		}
		else{
			return $(`#${this._id} > tbody > tr:nth-child(${i})`);
		}
	}

	valueC(c,v){
		if(v === undefined)
			return $(this._row).find(`.${c}`).val();
		else
			$(this._row).find(`.${c}`).val(v);
	}

	value(i){
		return $(this._row).find(`td:nth-child(${i}) > input`).val()
	}

	thisRow(obj){
		return $(obj).closest('tr')
	}

	focus(i = 1){
		if(i < 0){
			i = Math.abs(i);
			$(this._row).find(`td:nth-last-child(${i}) > input.rf`).focus();
		}
		else{
			$(this._row).find(`td:nth-child(${i}) > input.rf`).focus();
		}
	}

	get addBtn(){
		return $(`#${this._id}`).find('#add-row');
	}

	cloneRow(){
		let tr = $('#'+this._config.clonedId+' > tbody > tr:first').clone();
		return tr;
	}

	addRow(){
		if (this.rowCount === 0) {
			$(`#${this._id} > tbody`).append(this.cloneRow());
		}
		else{
			$(`#${this._id} > tbody > tr:last`).after(this.cloneRow());
		}
	}


	text(i, text){
		if('text' in this._config){
			let ct = ('in' in this._config.text)? this._config.text.in : 'tbody';
			switch(this._config.text.event){
				case 'rowFixed': if(this._config.text.value === 'last'){
					this.inst.find(`${ct} tr:last td:nth-child(${i})`).html(text);
				}
				break;
				default : $(this._row).find(`td:nth-child(${i})`).html(text);
				break;
			}
		}
	}

	textC(c,text){
		$(this._row).find(`.${c}`).html(text);
	}

	hideC(c){
		$(this._row).find(`.${c}`).removeClass('show').addClass('hidden');
	}

	showC(c){
		$(this._row).find(`.${c}`).removeClass('hidden').addClass('show');
	}

	findC(c){
		return $(this._row).find(`.${c}`);
	}





}