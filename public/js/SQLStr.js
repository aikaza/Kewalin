class SQLStr{

	constructor(){
		this._init_select = " SELECT ";
		this._init_from = " FROM ";
		this._init_default = " SELECT * FROM ";
		this._init_comma = ",";
		this._config = {};
	}

	set config(config) { this._config = config };

	get strOfSelect(){
		if('select' in this._config){
			if(this._config.select.length !== 0)
				return 'SELECT '+this._config.select.join(',')+' FROM ';
		}
		return this._init_default;
	}
	get strOfJoin(){
		if('join' in this._config){
			if(this._config.join.length !== 0){
				return this._config.join.reduce( (acc, value) => {
					return acc + ' ' + value[0] + ' ' + value[1] + ' ON ' + value[2] + ' = ' + value[3]; 
				},'');
			}
		}
		return '';
	}

	get strOfCondition(){
		if('condition' in this._config){
			if(this._config.condition.length !== 0){
				let mapCond =  this._config.condition.map( (n) => {
					if(n[1] === null && n[2] === null){
						// check if it is conditionRaw
						return n[3];
					}
					else{
						let copiedn = n.slice(1);
						if(n[2] === 'between')
							return `${n[1]} ${n[2]} ${n[3][0]} AND ${n[3][1]}`;
						else 
							return  copiedn.join(' ');
					}
				}).join(' AND ');
				return ' WHERE ' + mapCond;
			}
		}
		return '';
	}

	get strOfGroupBy(){
		if('groupby' in this._config){
			if(this._config.groupby.length !== 0)
				return ' GROUP BY ' + this._config.groupby.join(',');
		}
		return '';
	}

	get strOfHaving(){
		if('having' in this._config){
			if(this._config.having.length !== 0){
				let mapHaving =  this._config.having.map( (n) => {
					let copiedn = n.slice(1);
					if(n[2] === 'between')
						return `${n[1]} ${n[2]} ${n[3][0]} AND ${n[3][1]}`;
					else 
						return  copiedn.join(' ');
				}).join(' AND ');
				return ' HAVING ' + mapHaving;
			}
		}
		return '';
	}

	get strOfOrderBy(){
		if('orderby' in this._config){
			if(this._config.orderby.length !== 0)
				return ' ORDER BY ' + this._config.orderby.join(',');
		}
		return '';
	}
	
	get sqlString(){
		let sqlStr = '';
		sqlStr += this.strOfSelect;
		sqlStr += this._config.primaryTable;
		sqlStr += this.strOfJoin;
		sqlStr += this.strOfCondition;
		sqlStr += this.strOfGroupBy;
		sqlStr += this.strOfHaving;
		sqlStr += this.strOfOrderBy;
		return sqlStr;
	}


	// param =>  id, colname, condition, value
	addCondition(...param){
		if(!('condition' in this._config)) this._config.condition = [];
		this._config.condition = this._config.condition.filter( (n) => {
			return n[0] != [...param][0];
		});
		this._config.condition.push([...param]);
	}
	// param =>  id
	deleteCondition(id){
		if(!('condition' in this._config)) this._config.condition = [];
		this._config.condition = this._config.condition.filter( (n) => {
			return n[0] !== id;
		});
	}
	// param =>  obj
	addConditionByProp(obj){
		if(!$(obj).hasClass('sch-default')){
			let id = $(obj).attr('id');
			let colname = $(obj).attr('colname');
			let cond = $(obj).attr('cond');
			let value = $(obj).attr('val');
			this.addCondition(id,colname,cond,value);
		}
	}

	// param => value
	addConditionRaw(id,value){
		this.addCondition(id,null,null,value);
	}

	// param =>  type, table, left, right
	addJoin(...param){
		if(!('join' in this._config)) this._config.join = [];
		if(this._config.join.find( (n) => n[1] === [...param][1]) === undefined)
			this._config.join.push([...param]);
	}
	// param =>  table
	deleteJoin(table){
		if(!('join' in this._config)) this._config.join = [];
		let _table = table.trim().split(' ')[0];
		this._config.join = this._config.join.filter(function(n){
			return n[1].trim().split(' ')[0] != _table 
		});
	}

	// param =>  colname
	addGroupBy(colname){
		if(!('groupby' in this._config)) this._config.groupby = [];
		if(this._config.groupby.find( (n) => n === colname) === undefined){
			this._config.groupby.push(colname);
		}
	}
	// param =>  colname
	deleteGroupBy(colname){
		if(!('groupby' in this._config)) this._config.groupby = [];
		this._config.groupby = this._config.groupby.filter( (n) => {
			return n !== colname;
		});
	}

	// param =>  id, colname, condition, value
	addHaving(...param){
		if(!('having' in this._config)) this._config.having = [];
		if(this._config.having.find( (n) => n[0] === [...param][0]) === undefined)
			this._config.having.push([...param]);
	}
	// param =>  id
	deleteHaving(id){
		if(!('having' in this._config)) this._config.having = [];
		this._config.having = this._config.having.filter( (n) => {
			return n[0] !== id;
		});
	}

	addSelect(colname){
		if(!this._config.select.includes(colname)){
			this._config.select.push(colname);
		}
	}





}