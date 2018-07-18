<?php 

namespace App\Traits;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
trait StockTrait {

	protected function maxProductId(){
		$max_pd_id = \DB::
		select('SELECT MAX(id) as max FROM products');
		return (empty($max_pd_id)) ? 0 : $max_pd_id[0]->max;
	}

	protected function minProductId(){
		$min_pd_id = \DB::
		select('SELECT MIN(id) as min FROM products');
		return (empty($min_pd_id)) ? 0 : $min_pd_id[0]->min;
	}

	protected function maxProductRemain(){
		$max_pd_remain = \DB::select('
			SELECT SUM(qtyp) as qtypsum FROM stocks GROUP BY product_id ORDER BY qtypsum DESC LIMIT 1');
		return (empty($max_pd_remain)) ? 0 : $max_pd_remain[0]->qtypsum;
	}

	protected function minProductRemain(){
		$min_pd_remain = \DB::select('
			SELECT SUM(qtyp) as qtypsum FROM stocks GROUP BY product_id ORDER BY qtypsum LIMIT 1');
		return (empty($min_pd_remain)) ? 0 : $min_pd_remain[0]->qtypsum;
	}

	protected function storeStock($lot_no, $unit, array $p_code, array $p_color, array $qtyp, array $qtys, array $cst,$note){

		$p_code_unique = array_unique($p_code);
		foreach ($p_code_unique as $index => $value) {
			$find_index = array_keys($p_code, $value);
			$qtyp_ = 0;
			$color_detail_ = [];
			$color_detail = [];
			$qtyp_detail = [];
			foreach ($find_index as $i) {
				$qtyp_ += $qtyp[$i];
				array_push($color_detail_, $p_color[$i].'='.$qtyp[$i]);
				array_push($color_detail,$p_color[$i]);
				array_push($qtyp_detail,$qtyp[$i]);
			}

			$st = new \App\Stock;
			$st->lot_number = $lot_no;
			$st->product_id = $this->getProductIdByCode($value);
			$st->qtyp = $qtyp_;
			$st->unit_id = $unit;
			$st->note = $note;
			$res = $st->save();
			if($res){
				for ($i=0; $i < sizeof($color_detail); $i++) { 
					$st_color_detail = new \App\StockPColorDetail;
					$st_color_detail->stock_id = $st->id;
					$st_color_detail->color_code = $color_detail[$i];
					$st_color_detail->qtyp = $qtyp_detail[$i];
					$st_color_detail->save();
				}
			}
		}

		for ($i = 0; $i < sizeof($p_code); $i++) {

			$ip = new \App\Import;
			$ip->lot_number = $lot_no;
			$ip->product_id = $this->getProductIdByCode($p_code[$i]);
			$ip->product_color = $p_color[$i];
			$ip->qtyp = $qtyp[$i];
			$ip->qtys = $qtys[$i];
			$ip->unit_id = $unit;
			$ip->cost_per_unit = $cst[$i];
			$ip->total_cost = $qtys[$i] * $cst[$i];
			$ip->created_by = Auth::id();
			$ip->save();
		}
	}

	private function getProductIdByCode($code){
		$pd_id = \App\Product::where('code',$code)->value('id');
		return $pd_id;
	}



}