<?php 


namespace App\Traits\Datatables;

use DataTables;
use Illuminate\Http\Request;

trait ExportIndexDtTrait{


	public function ExportIndexDt(Request $rq){
		$od = \DB::select("
			SELECT * FROM(
				$rq->sqlString
			) as sub
			ORDER BY FIELD(complete, 'no', 'yes'), updated_at DESC
		");
		return DataTables::of($od)
		->addIndexColumn()
		->editColumn('customer', function($od){
			return '<a href="'.route('customers.detail',$od->customer_id).'">'.$od->customer.'</a>';
		})
		->editColumn('created_at', function($od){
			return explode(' ',$od->created_at)[0];
		})
		->addColumn('action', function ($od) use ($rq){
			$str = '';
			if ($od->statusval === 'no') {
				$str .= '<a href="'.route('exports.show.insert.price',$od->code_id).'" class="btn btn-link text-success">';
				$str .= 'ใส่ราคาสินค้า';
				$str .= '</a>';		
			}
			else{
				$str .= '<a href="'.route('exports.detail.price',$od->code_id).'" class="text-primary">';
				$str .= 'รายละเอียด</a>';
			}
			
			return   $str; 
		})
		->rawColumns(['product','qtyp','status','action','customer'])
		->toJson();
	}

}