<?php 


namespace App\Traits\Datatables;

use DataTables;
use Illuminate\Http\Request;

trait ExportDebtListDtTrait{


	public function ExportDebtListDt($customer_id){


		$data = \DB::select("
			SELECT cd.code code, MAX(e.created_at) date,
			SUM(o.qtyp) qtyp, SUM(e.qtys) qtys, SUM(e.total_price) total,
			GROUP_CONCAT(DISTINCT o.customer_id) customer_id,
			GROUP_CONCAT(DISTINCT e.makebill) makebill
			FROM exports e
			INNER JOIN orders o ON o.id = e.order_id
			INNER JOIN customers c ON c.id = o.customer_id
			INNER JOIN codes cd ON cd.id = e.code_id 
			GROUP BY code
			HAVING customer_id = $customer_id AND makebill = 'no'
			ORDER BY date DESC
			");

		$tosend = [
			'customer' => \App\Customer::find($customer_id),
			'data'   => $data
		];
		return view('invoice.make-bill',$tosend);

		
		$ex = \DB::select("
			SELECT * FROM(
			$rq->sqlString
			) as sub
			ORDER BY created_at DESC
			");
		return DataTables::of($od)
		->addIndexColumn()
		->editColumn('customer', function($od){
			return '<a href="'.route('customers.detail',$od->customer_id).'">'.$od->customer.'</a>';
		})
		->editColumn('created_at', function($od){
			return explode(' ',$od->created_at)[0];
		})
		->addColumn('action', function ($od) {
			$str = '';
			if ($od->statusval === 'no') {
				$str .= '<a href="'.route('exports.show.insert.price',$od->code_id).'" class="btn btn-link text-success">';
				$str .= 'ทำรายการ</a>|';		
			}
			else{
				$str .= '<a class="btn btn-link text-primary bill-download" code="'.$od->code_id.'">';
				$str .= 'ดาวน์โหลดใบเสร็จ</a>|';	
			}
			$str .= '<a href="#" class="btn btn-link text-primary">';
			$str .= 'รายละเอียด</a>';
			return   $str; 
		})
		->rawColumns(['product','qtyp','status','action','customer'])
		->toJson();
	}

}