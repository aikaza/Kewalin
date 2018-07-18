<?php 

namespace App\Traits;
use DataTables;
use Illuminate\Support\Facades\Storage;
trait ProductTrait {



	protected function countRecords($id,$model,$join = null){
		if($join === null)
			$count = $model->where('product_id',$id)->count();
		else 
			$count = $model->join($join[0],$join[1],$join[2])
					->where('product_id',$id)->count();
		return $count;
	}

	

}