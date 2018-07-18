<?php 

namespace App\Classes;

class ExportPriceBuilder{

	protected $data;


	public function setData(array $id, array $qtys, array $price_per_unit){
		$this->data['id'] = $id;
		$this->data['qtys'] = $qtys;
		$this->data['price_per_unit'] = $price_per_unit;
		$this->data['arr'] = $this->serializeData($id, $qtys, $price_per_unit);
	}

	public function make(){
		extract($this->data);
		$refcode = str_random(6);
		foreach ($arr as $key => $d) {
			$exp = \App\Export::find($d['id']);
			$exp->price_per_unit = $d['price_per_unit'];
			$exp->total_price = $d['price_per_unit'] * $d['qtys'];
			$exp->complete = 'yes';
			$exp->save();
			$this->storeExportedDebt($exp->order->customer->id, $exp->id, $exp->total_price, $refcode);
		}
	}



	protected function storeExportedDebt($id_customer, $id_export, $total, $refcode){
		$iv = new \App\Invoice;
		$iv->export_id = $id_export;
		$iv->customer_id = $id_customer;
		$iv->total = $total;
		$iv->refcode = $refcode;
		$res = $iv->save();	
		return $res;
	}

	protected function serializeData(array $id, array $qtys, array $price_per_unit){
		$count = count($qtys);
		$arr = array();
		for ($i=0; $i < $count; $i++) { 
			$arr[$i]['id'] = $id[$i];
			$arr[$i]['qtys'] = $qtys[$i];
			$arr[$i]['price_per_unit'] = $price_per_unit[$i];
		}
		return $arr;
	}
}