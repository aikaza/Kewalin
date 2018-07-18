<?php 


namespace App\Traits\Datatables;

use DataTables;
use Illuminate\Http\Request;

trait BillListDtTrait{


	public function BillListDt($customer_id){


		$data = \DB::select("
			SELECT b.filename filename, b.filepath filepath, cd.code code, cd.id code_id, date(b.created_at) date
			FROM bills b
			INNER JOIN codes cd ON cd.id = b.code_id
			INNER JOIN debtbills db ON db.code_id = cd.id
			WHERE db.customer_id = $customer_id
			ORDER BY b.created_at DESC
			");
		return DataTables::of($data)
		->addIndexColumn()
		->addColumn('action', function ($data) {
			$str = '<a class="text-primary bill-download" code="'.$data->code_id.'" href="/bill/'.$data->filepath.'/download">';
			$str .= 'ดาวน์โหลดไฟล์</a>';	
			return   $str; 		
		})
		->rawColumns(['action'])
		->toJson();
	}

}