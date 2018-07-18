<?php 

namespace App\Classes;

use Illuminate\Support\Facades\Auth;

class ImportBuilder{

	protected $data;


	public function setLotNumber($lot_number){
		$this->data['lot_number'] = $lot_number;
	}

	public function setUnit($unit){
		$this->data['unit'] = $unit;
	}

	public function setSerializedData(array $serialized_data){
		$this->data['arr'] = $serialized_data;
	}

	public function make(){
		extract($this->data);
		foreach ($arr as $key => $d) {
			$imp = new \App\Import;
			$imp->lot_number = $lot_number;
			$imp->unit_id = $unit;
			$imp->product_id = $d['product_id'];
			$imp->product_color = $d['product_color'];
			$imp->qtyp = $d['qtyp'];
			$imp->qtys = $d['qtys'];
			$imp->cost_per_unit = $d['cost_per_unit'];
			$imp->total_cost = $d['qtys'] * $d['cost_per_unit'];
			$imp->created_by = Auth::id();
			$imp->save();
		}
	}
}