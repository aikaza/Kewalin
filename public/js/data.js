class Data{

	constructor(){
		this._data = {};
	}

	keep(key,value){
		this._data[key] = value;
	}

	get(key){
		return this._data[key];
	}

	has(key){
		if(this._data.c_id !== undefined) {
			return true;
		}else{
			return false;
		}
	}

	all(){
		return this._data;
	}


}