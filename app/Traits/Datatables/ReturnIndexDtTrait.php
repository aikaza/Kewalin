<?php

namespace App\Traits\Datatables;

use DataTables;

trait ReturnIndexDtTrait{

	public function ReturnIndexDt(){
		$od = \DB::select("
			SELECT * FROM
			(		SELECT cd.code order_code, MAX(r.updated_at) updated_at,
             		GROUP_CONCAT( CONCAT(p.code,' &emsp; ', p.name, ' &bull; ', o.product_color) SEPARATOR '<br>') product,
					GROUP_CONCAT( TRIM(r.returned_qtyp)+0  SEPARATOR '<br>') qtyp,
					GROUP_CONCAT( coalesce(r.detail,'ไม่ระบุ') SEPARATOR '<br>') detail
					FROM returns r
					INNER JOIN exports e ON e.id = r.export_id
					INNER JOIN orders o ON o.id = e.order_id
					INNER JOIN products p ON p.id = o.product_id
					INNER JOIN codes cd ON cd.id = e.code_id
					GROUP BY order_code
			) as sub
			ORDER BY updated_at DESC
		");
		return DataTables::of($od)
		->rawColumns(['product','qtyp','detail'])
		->toJson();
	}
}