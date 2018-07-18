<?php 


namespace App\Traits\Datatables;

use DataTables;

trait ImportListDtTrait{

	public function ImportListDt($product_id){
		$list = \DB::select("
			SELECT qtyp, qtys, UPPER(u.prefix) unit, date(im.created_at) created_at, us.name created_by,im.cost_per_unit cost_per_unit,lot_number lot_number,product_color p_color
			FROM imports im
			INNER JOIN units u ON u.id = im.unit_id
			INNER JOIN users us ON us.id = im.created_by
			WHERE product_id = ?
			ORDER BY im.created_at DESC
			",[$product_id]);
		return DataTables::of($list)
		->addIndexColumn()
		->editColumn('qtys', function($list){
			return number_format($list->qtys).' '.$list->unit;
		})
		->editColumn('qtyp', function($list){
			return number_format($list->qtyp);
		})
		->editColumn('cost_per_unit', function($list){
			return '&#3647; '.number_format($list->cost_per_unit);
		})
		->rawColumns(['cost_per_unit'])
		->make(true);
	}
}