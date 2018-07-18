<?php 

namespace App\Classes;


use App\Classes\ImportBuilder;
use App\Classes\ProductColorBuilder;

class StockBuilder{

	protected $data;


	public function setLotNumber($lot_number){
		$this->data['lot_number'] = $lot_number;
	}

	public function setUnit($unit){
		$this->data['unit'] = $unit;
	}

	public function setNote($note){
		$this->data['note'] = $note;
	}

	public function setPrimaryData(array $product_code, array $product_color, array $qtyp, array $qtys, array $cost_per_unit){
		$this->data['product_code'] = $product_code;
		$this->data['product_color'] = $product_color;
		$this->data['qtyp'] = $qtyp;
		$this->data['qtys'] = $qtys;
		$this->data['cost_per_unit'] = $cost_per_unit;
		$this->data['arr'] = $this->serializeData($product_code, $product_color, $qtyp, $qtys, $cost_per_unit);
	}


	public function make(){
		extract($this->data);
		$product_code_unique = array_unique($product_code);
		foreach ($product_code_unique as $index => $value) {
			$_index_arr = array_keys($product_code, $value);
			$_qtyp = 0;
			$_product_color = [];
			$_product_color_qtyp = [];
			foreach ($_index_arr as $i) {
				$_qtyp += $qtyp[$i];
				array_push($_product_color, $product_color[$i]);
				array_push($_product_color_qtyp, $qtyp[$i]);
			}
			$st = new \App\Stock;
			$st->lot_number = $lot_number;
			$st->product_id = $this->getProductIdByCode($value);
			$st->qtyp = $_qtyp;
			$st->unit_id = $unit;
			$st->note = $note;
			$st->save();
			for ($i=0; $i < count($_product_color); $i++) { 
				$this->storeProductColor($st->id, $_product_color[$i], $_product_color_qtyp[$i]);
			}
		}
		$this->storeImport($lot_number, $unit, $arr);
	}



	protected function serializeData( array $product_code, array $product_color, array $qtyp, array $qtys, array $cost_per_unit ){
		$count = count($product_code);
		$arr = array();
		for ($i=0; $i < $count; $i++) { 
			$arr[$i]['product_id'] = $this->getProductIdByCode($product_code[$i]);
			$arr[$i]['product_color'] = $product_color[$i];
			$arr[$i]['qtyp'] = $qtyp[$i];
			$arr[$i]['qtys'] = $qtys[$i];
			$arr[$i]['cost_per_unit'] = $cost_per_unit[$i];
		}
		return $arr;
	}


	protected function getProductIdByCode($product_code){
		$product_id = \App\Product::where('code',$product_code)->value('id');
		return $product_id;
	}

	protected function storeImport($lot_number, $unit, array $arr){
		$imb = new ImportBuilder;
		$imb->setLotNumber($lot_number);
		$imb->setUnit($unit);
		$imb->setSerializedData($arr);
		$imb->make();
	}

	protected function storeProductColor($stock_id, $color_code, $qtyp){
		$pclr = new ProductColorBuilder;
		$pclr->setData($stock_id, $color_code, $qtyp);
		$pclr->make();
	}


}