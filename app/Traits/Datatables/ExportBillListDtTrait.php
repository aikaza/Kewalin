<?php 


namespace App\Traits\Datatables;

use DataTables;
use Illuminate\Http\Request;

trait ExportBillListDtTrait{


	public function ExportBillListDt(Request $rq, $customer_id){

		$str = "";
		if($rq->type === 'new'){
			$str = " AND makebill = 'no' ";
		}

		$od = \DB::select("
			SELECT cd.code code, MAX(e.created_at) date,
			SUM(o.qtyp) qtyp, SUM(e.qtys) qtys, SUM(e.total_price) total,
			GROUP_CONCAT(DISTINCT o.customer_id) customer_id,
			GROUP_CONCAT(DISTINCT u.name) unit,
			GROUP_CONCAT(DISTINCT e.makebill) makebill
			FROM exports e
			INNER JOIN orders o ON o.id = e.order_id
			INNER JOIN customers c ON c.id = o.customer_id
			INNER JOIN codes cd ON cd.id = e.code_id 
			INNER JOIN units u ON u.id = e.unit_id
			GROUP BY code
			HAVING customer_id = ? AND total is not NULL ".$str."
			ORDER BY date DESC
			",[$customer_id]);

		return DataTables::of($od)
		->editColumn('index', function($od){
			return '<input type="checkbox" name="export_codes[]" value="'.$od->code.'" form="form" class="checkbox">';
		})
		->editColumn('qtys', function($od){
			return $od->qtys.' '.$od->unit;
		})
		->editColumn('total', function($od){
			return '&#3647; '.$od->total;
		})
		->editColumn('date', function($od){
			return explode(' ', $od->date)[0];
		})
		->rawColumns(['index','total'])
		->toJson();
	}

}