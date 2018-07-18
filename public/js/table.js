class Table{

	constructor(id){
		this._id = id;
		this._inst = getElmById(id);
		this._ob = null;
	}

	getInst(){
		return this._inst;
	}

	setRowsCount(rowCount){
		this._rowCount = rowCount;
	} 

	getRowsCount(){
		return $(`#${this._id} > tbody`).children().length - 2;
	}

	addRow(){
		let new_row = this.getCloneRow(1);
		$(`#${this._id} tr:last`).before(new_row);
	}

	display(id, text){
		$(`#${id}`).html(text);
	}

	displayAt(no_row, no_col,text){
		$(`#${this._id} > tbody > tr:nth-child(${no_row} > td:nth-child(${no_col}))`).html(text);
	}

	getLastRow(){
		return $(`#${this._id} tr:last`);
	}

	firstRow(){
		return $(`#${this._id} > tbody > tr:first`);
	}

	getRowAt(no_row, no_col = null ){
		if (no_col !== null)
			return $(`#${this._id} > tbody > tr:nth-child(${no_row} > td:nth-child(${no_col})`);
		else
			return $(`#${this._id} > tbody > tr:nth-child(${no_row})`);
	}
	getCloneRow(no_row){
		return $(`#${this._id} >tbody > tr:nth-child(${no_row})`).clone().removeAttr('id').removeClass('hidden');
	}

	valAt(c, id=null){
		return $(this._ob).closest('tr').find(`.${c}`).val();
	}

	setValAt(c, val, id=null){
		return $(this._ob).closest('tr').find(`.${c}`).val(val);
	}

	hideRowAt(c){
		$(this._ob).closest('tr').find(`.${c}`).removeClass('show').addClass('hidden');
	}

	showRowAt(c){
		$(this._ob).closest('tr').find(`.${c}`).removeClass('hidden').addClass('show');
	}

	setOb(ob){
		this._ob = ob;
	}

	focusAt(no){
		$(this._ob).closest('tr').find(`td:nth-child(${no}) > input`).focus();
	}

	focusOnLastRow(c){
		this.getLastRow().prev().find(`.${c}`).focus();
	}	

	find(c){
		return $(this._ob).closest('tr').find(`.${c}`);
	}

}