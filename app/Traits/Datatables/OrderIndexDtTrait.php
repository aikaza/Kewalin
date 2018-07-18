<?php 

namespace App\Traits\Datatables;

use DataTables;
use Illuminate\Http\Request;

trait OrderIndexDtTrait{

	public function OrderIndexDt(Request $rq){
		if($rq->ajax()){
			$od = \DB::select("
				SELECT * FROM (
					$rq->sqlString
				) as sub
				ORDER BY FIELD(statusval, 'prepare', 'success'), updated_at DESC
			");
		}
		return DataTables::of($od)
		->addIndexColumn()
		->editColumn('created_at',function($od){
			return explode(' ',$od->created_at)[0];
		})
		->editColumn('customer', function($od){
			return '<a href="'.route('customers.detail',$od->customer_id).'">'.$od->customer.'</a>';
		})
		->addColumn('action', function ($od) {
			$str = '';
			if($od->statusval === 'prepare'){
				$str .= '<a href="'.route('exports.create',['refcode' => $od->code_id, 'pattern' => 1]).'" class="btn btn-link text-success">';
				$str .= 'นำสินค้าออก</a> |';
				$str .= '<a href="'.route('orders.edit',$od->code_id).'" class="btn btn-link text-primary">';
				$str .= 'แก้ไข</a> |';
				$str .= '<a href="'.route('orders.cancel',$od->code_id).'" class="btn btn-link text-danger cancel-btn">';
				$str .= 'ยกเลิกรายการ</a>';
			}
			if($od->statusval === 'success'){
				$str .= '<a class="btn btn-link text-info bill-download" code="'.$od->code_id.'">';
				$str .= 'ดาวน์โหลดไฟล์';
				$str .= '</a> |';
				$str .= '<a href="'.route('exports.detail',$od->code_id).'" class="btn btn-link text-primary">';
				$str .= 'รายละเอียด</a>';
			}

			return   $str; 
		})
		->rawColumns(['product','qtyp','status','action','customer'])
		->toJson();
	}

}