<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Stock;
use App\Configuration;
use App\Events\ProductDeleted;
class Product extends Model
{

	protected $fillable = ['name','color','created_at','updated_at'];


	public function images(){
		return $this->hasMany('App\Image');
	}

	public function stocks(){
		return $this->hasMany('App\Stock');
	}

	public function orders(){
		return $this->hasMany('App\Order');
	}


	public function remain($p_id){
		$s = Stock::where('product_id',$p_id)->sum('qtyp');
		if($s === null) $s = 0;
		return $s;
	}

	public function imports(){
		return $this->hasMany('App\Import');
	}
	
	public function totalImportBudget(){
		
	}

	public function totalExportIncome(){
		
	}

	public function yard($p_id){
		$s = Stock::where('product_id',$p_id)->sum('no_yards');
		return $s;
	}

	public function lotNo($p_id){
		$lot = Stock::select('lot_number')
		->where('product_id',$p_id)
		->where('qtyp','>',0)
		->get();
		return $lot;
	}

	public function shouldExport($p_id,$qtyp){
		$lot = Stock::select('lot_number','qtyp')
		->where('product_id',$p_id)
		->where('qtyp','>',0)
		->get();
		$shouldExport = [];
		$rolls = $qtyp;
		foreach ($lot as $value) {
			if($rolls > $value->qtyp){
				array_push($shouldExport, $value->lot_number);
				$rolls = $rolls - $value->qtyp;
			}
			else{
				array_push($shouldExport, $value->lot_number);
				$rolls = 0;
				break;
			}
		}
		if($rolls !== 0) return array();
		else return $shouldExport;
	}


}
