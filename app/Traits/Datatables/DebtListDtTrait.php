<?php 


namespace App\Traits\Datatables;

use DataTables;
use Illuminate\Http\Request;

trait DebtListDtTrait{


	public function DebtListDt(Request $rq, $customer_id){

		$str = '';
		if($rq->status !== 'all'){
			$str = ' WHERE db.status = ?';
		}
		$data = \DB::select("
			SELECT cd.code bill_number, db.total_debt total,
			db.updated_at updated_at, cd.id code_id,
			date( db.created_at) date, db.status status
			FROM debtbills db 
			INNER JOIN codes cd on cd.id = db.code_id
			".$str."
			ORDER BY FIELD(status, 'pending','paid'), updated_at DESC
			", [ $rq->status]);
		return DataTables::of($data)
		->addIndexColumn()
		->editColumn('status', function($data){
			if($data->status === 'pending'){
				return 'ยังไม่ได้ชำระ';
			}
			else{
				return 'ชำระแล้ว';
			}
		})
		->editColumn('total', function($data){
			return '&#3647; '. trim(number_format($data->total,2),'.00');
		})
		->addColumn('action', function($data){
			$str = "ไม่มีการกระทำ";
			if($data->status !== 'paid'){
				$str = '<a class="text-success action paid" cid="'.$data->code_id.'" style="cursor: pointer;">ชำระเงินแล้ว</a>'; 
			}
			return $str;    
		})
		->rawColumns(['total','action'])
		->toJson();
	}

}