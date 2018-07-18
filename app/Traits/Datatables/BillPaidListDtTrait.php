<?php 


namespace App\Traits\Datatables;

use DataTables;
use Illuminate\Http\Request;

trait BillPaidListDtTrait{


	public function BillPaidListDt($customer_id){

		$data = \DB::select("
			SELECT t.bank bank, t.cheque_number cheque_number, t.issue_date issue_date, t.note note, cd.code bill_number, db.total_debt total_debt
			FROM transactions t
			INNER JOIN debtbills db ON db.id = t.debtbill_id
			INNER JOIN codes cd ON cd.id = db.code_id
			WHERE db.customer_id = $customer_id and db.status = 'paid'
			ORDER BY t.created_at DESC
			");
		return DataTables::of($data)
		->addIndexColumn()
		->editColumn('total_debt', function($data){
			return '&#3647; '. trim(number_format($data->total_debt,2),'.00');
		})
		->toJson();
	}

}