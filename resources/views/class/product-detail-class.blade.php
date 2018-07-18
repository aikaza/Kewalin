@php


class ProductDetail{

	private $id;

	public function __construct($id){
		$this->id = $id;
	}

	public function getProductRemainCount(){
		$p = \App\Stock::select(\DB::raw('SUM(qtyp) as remain'))
		->where('product_id',$this->id)
		->groupBy('product_id')
		->first();
		return ( $p === null ) ? 0 : $p->remain;
	}

	public function getProductOrderCount(){
		$p = \App\Order::select(\DB::raw('SUM(qtyp) as qtyp'))
		->groupBy('product_id')
		->having('product_id',$this->id)
		->where('status','prepare')
		->first();
		return ($p === null) ? 0 : $p->qtyp;
	}

	public function getProductImportCount(){
		$p = \App\Import::select(\DB::raw('SUM(qtyp) as qtyp'))
		->groupBy('product_id')
		->having('product_id',$this->id)
		->first();
		return ($p === null) ? 0 : $p->qtyp;
	}

	public function getProductExportCount(){
		$p = \App\Export::join('orders','orders.id','exports.order_id')
		->select(\DB::raw('SUM(orders.qtyp) as qtyp'))
		->groupBy('orders.product_id')
		->having('orders.product_id',$this->id)
		->first();
		return ($p === null) ? 0 : $p->qtyp;
	}

	public function getProductRemainList(){
		$p = \App\Stock::select(\DB::raw('lot_number, qtyp, date(updated_at) as date'))
		->where('product_id',$this->id)
		->where('qtyp','<>',0)
		->get();
		return $p;
	}

	public function getProductOrderList(){
		$p = \App\Order::select(\DB::raw('qtyp, date(created_at) as date, customer_id,code_id,product_color'))
		->where('product_id',$this->id)
		->where('status','prepare')
		->limit(10)
		->get();
		return $p;
	}

	public function getProductImportList(){
		$p = \App\Import::select(\DB::raw('id,qtyp, date(created_at) as date, created_by,qtys,unit_id,cost_per_unit,lot_number,product_color'))
		->where('product_id',$this->id)
		->orderBy('created_at','desc')
		->limit(10)
		->get();
		return $p;
	}

	public function getProductExportList(){
		$p = \App\Export::join('orders','orders.id','exports.order_id')
		->select(\DB::raw('exports.id,orders.qtyp, qtys, date(exports.created_at) as date, exports.created_by,qtys,unit_id,price_per_unit,lot_number,orders.product_color as p_color'))
		->where('orders.product_id',$this->id)
		->orderBy('exports.created_at','desc')
		->limit(10)
		->get();
		return $p;
	}




}


@endphp