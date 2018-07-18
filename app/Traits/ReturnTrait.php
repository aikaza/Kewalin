<?php 

namespace App\Traits;

trait ReturnTrait{


	private function storeReturn($export_code,$pcolor, $qtyp, $qtys){
		$export_id = \App\Export::whereHas('code', function($query) use($export_code){
			$query->where('code',$export_code);
		})->whereHas('order', function($query) use ($pcolor){
			$query->where('product_color',$pcolor);
		})->value('id');

		$returning = new \App\Returning;
		$returning->export_id = $export_id;
		$returning->returned_qtyp = $qtyp;
		$returning->detail = $qtys;
		$res = $returning->save();
		return $res;
	}

	private function updateQtypInStock($export_code,$pcolor,$qtyp){
		$lot_number = $this->getReturnedLotNumber($export_code,$pcolor);
		\DB::statement("
			UPDATE stocks
			SET qtyp = qtyp + $qtyp
			WHERE product_id = (
			SELECT product_id FROM exports e INNER JOIN orders o ON e.order_id = o.id INNER JOIN codes cd ON cd.id = e.code_id WHERE cd.code = '$export_code' AND o.product_color = '$pcolor'
			)
			AND lot_number = '$lot_number'
			");
		\DB::statement("
			UPDATE stock_pcolor_details
			SET qtyp = qtyp + $qtyp
			WHERE stock_id = (
			SELECT id FROM stocks WHERE lot_number = '$lot_number' AND product_id = 
				(
			SELECT product_id FROM exports e INNER JOIN orders o ON e.order_id = o.id INNER JOIN codes cd ON cd.id = e.code_id WHERE cd.code = '$export_code' AND o.product_color = '$pcolor'
			)
			)
			AND color_code = '$pcolor'
			");		

	}

	private function getReturnedLotNumber($export_code,$pcolor){
		$lot_number_str = \App\Export::whereHas('code', function($query) use ($export_code){
			$query->where('code',$export_code);
		})
		->whereHas('order', function($query) use ($pcolor){
			$query->where('product_color',$pcolor);
		})->value('lot_number');
		$lot_number = explode(',',$lot_number_str)[0];
		$lot_number = explode('=',$lot_number)[0];
		return $lot_number;
	}


	
}