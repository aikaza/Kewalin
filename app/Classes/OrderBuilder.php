<?php 

namespace App\Classes;

use App\Classes\CodeGenerator;
use Illuminate\Support\Facades\Auth;

class OrderBuilder{

	protected $customer_id;
	protected $created_for;
	protected $arr;

	public function serializeData($customer_id, array $product_code, array $product_color, array $qtyp, $created_for){
		$count = count($product_code);
		$arr = array();
		for ($i=0; $i < $count; $i++) { 
			$arr[$i]['product_id'] = $this->getProductIdByCode($product_code[$i]);
			$arr[$i]['product_color'] = $product_color[$i];
			$arr[$i]['qtyp'] = $qtyp[$i];
		}
		$this->arr = $arr;
		$this->customer_id = $customer_id;
		$this->created_for = $created_for;
	}

	protected function getCodeId(){
		$cg = new CodeGenerator(appconfig('pv_prefix'), appconfig('pv_length'));
		$cg->make();
		return $cg->getId();
	}

	protected function getProductIdByCode($product_code){
		$product_id = \App\Product::where('code',$product_code)->value('id');
		return $product_id;
	}

	public function make(){
		$code_id = $this->getCodeId();
		foreach ($this->arr as $d) {
			$od = new \App\Order;
			$od->customer_id    = $this->customer_id;
			$od->product_id     = $d['product_id'];
			$od->product_color  = $d['product_color'];
			$od->qtyp           = $d['qtyp'];
			$od->code_id        = $code_id;
			$od->created_by     = Auth::id();
			$od->created_for	= $this->created_for;
			$od->save();
		}
	}





}