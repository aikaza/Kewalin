<?php 

namespace App\Traits;

use DataTables;
use Illuminate\Http\Request;

trait OrderTrait {

	protected function minQtyp(){
		$min_qtyp = \DB::select('
			SELECT SUM(qtyp) qtypsum FROM orders GROUP BY code_id  
			ORDER BY qtypsum ASC LIMIT 1');
		return (empty($min_qtyp)) ? 0 : $min_qtyp[0]->qtypsum;
	}

	protected function maxQtyp(){
		$max_qtyp = \DB::select('
			SELECT SUM(qtyp) qtypsum FROM orders GROUP BY code_id  
			ORDER BY qtypsum DESC LIMIT 1');
		return (empty($max_qtyp)) ? 0 : $max_qtyp[0]->qtypsum;
	}

	protected function generateRefCode(){
		$prefix = appconfig('pv_prefix');
		$number = $this->getLastOrderNumber();
		$new_number = sprintf('%0'.appconfig('pv_length').'d', $number + 1);
		$code = $prefix.$new_number;
		return $code;
	}

	protected function cancel(\App\Order $odrs){
		foreach ($odrs as $od) {
			if($od->status === 'success'){
				$export = \App\Export::select('lot_number')->where('order_id',$od->id)->first();
				$exported_lot_numbers = explode(',',$export->lot_number);
				foreach ($exported_lot_numbers as $key => $value) {
					$exported_lot_number 	= explode('=',$value)[0];
					$exported_qtyp 			= explode('=',$value)[1];
					$st = \App\Stock::where('product_id',$od->product_id)
					->where('lot_number',$exported_lot_number)
					->first();
					$st->qtyp += $val;
					$st->save();
				}
				$export->delete();
				$export->save();
			}
			$od->status = 'cancel';
			$od->save();
		}
	}


	private function getProductIdByCode($code){
		$pd_id = \App\Product::where('code',$code)->value('id');
		return $pd_id;
	}


	private function getLastOrderNumber(){
		$order_number =  \App\Order::where('code_prefix',appconfig('pv_prefix'))
		->orderBy('id','desc')->limit(1)->value('code_number');
		return ($order_number === null) ? 0 : $order_number;
	}

}