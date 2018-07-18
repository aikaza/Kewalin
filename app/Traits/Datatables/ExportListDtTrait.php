<?php 

namespace App\Traits\Datatables;

use DataTables;

trait ExportListDtTrait{

	public function ExportListDt($product_id){
		$list = \DB::select("
			SELECT o.qtyp qtyp , ex.qtys qtys, UPPER(u.prefix) unit, date(ex.created_at) created_at, us.name created_by,ex.price_per_unit price_per_unit,ex.lot_number lot_number,o.product_color p_color
			FROM exports ex
			INNER JOIN orders o ON o.id = ex.order_id
			INNER JOIN units u ON u.id = ex.unit_id
			INNER JOIN users us ON us.id = ex.created_by
			WHERE o.product_id = ?
			ORDER BY ex.created_at DESC
			",[$product_id]);
		return DataTables::of($list)
		->addIndexColumn()
		->editColumn('qtyp', function($list){
			return number_format($list->qtyp);
		})
		->editColumn('qtys', function($list){
			return number_format($list->qtys).' '.$list->unit;
		})
		->editColumn('price_per_unit',function($list){
			if ($list->price_per_unit === null) {
				return "-";
			}
			else{
				return '&#3647; '.$list->price_per_unit;
			}
		})
		->rawColumns(['price_per_unit'])
		->toJson();
	}
}