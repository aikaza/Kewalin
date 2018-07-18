@php

class CustomerDetail{

	private $id;

	public function __construct($id){
		$this->id = $id;
	}

	public function getCustomerOrderList(){
		$od = \App\Order::join('products', 'products.id', '=', 'orders.product_id')
		->selectRaw('GROUP_CONCAT(qtyp) as qtyp,
			code_id,GROUP_CONCAT(CONCAT("#",products.code," / ",product_color," ",products.name)) as product,
			GROUP_CONCAT(DISTINCT DATE(orders.created_at)) as date')
		->where('customer_id',$this->id)
		->groupBy('code_id')
		->orderBy('code_id','desc')
		->limit(10)
		->get();
		return $od;
	}

	public function getCustomerTotalDebt(){
		$debt = \App\Invoice::where([
			'status' => 'pending',
			'customer_id' => $this->id
		])->sum('total');
		return ($debt === null) ? 0 : $debt;
	}

	public function getCustomerOrderCount(){
		$qty = \App\Export::join('orders','orders.id','exports.order_id')
		->where('customer_id',$this->id)->sum('orders.qtyp');
		return ($qty === null) ? 0 : $qty;
	}

	public function getCustomerFavoriteProduct(){
		$prefer_product = \App\Export::join('orders','orders.id','exports.order_id')
		->selectRaw('product_id,product_color,SUM(qtyp) as qtyp')
		->where('customer_id',$this->id)
		->groupBy('product_id','product_color')
		->orderBy('qtyp','desc')
		->limit(1)
		->first();
		return $prefer_product;
	}

	public function getCustomerSupportRanking(){
		$res = \DB::select('SELECT customer_id, qtyp, rank FROM (
      			SELECT customer_id, qtyp, @rank := @rank + 1 as rank
      			FROM (
            	SELECT customer_id, sum(qtyp) qtyp
            	FROM   exports
            	INNER JOIN orders on orders.id = exports.order_id
            	GROUP BY customer_id
            	ORDER BY sum(qtyp) DESC
           		) t1, (SELECT @rank := 0) t2
     		) t3
			WHERE customer_id = '.$this->id);
		return (empty($res)) ? __('no rank') : $res[0]->rank;
	}
}

@endphp