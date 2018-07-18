<?php 

namespace App\Traits;

use DataTables;

trait CustomerTrait{


	protected function countRecords($id, $model,$join = null){
		if($join === null)
			$count = $model->where('customer_id',$id)->count();
		else
			$count = $model->join($join[0],$join[1],$join[2])
					->where('customer_id',$id)->count();
		return $count;
	}
}