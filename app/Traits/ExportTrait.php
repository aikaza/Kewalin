<?php 

namespace App\Traits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
trait ExportTrait {

	protected function storeExport(array $data){
		/*$args = func_get_args();
		$order_id 	= $args[0]; // Integer
		$p_id		= $args[1]; // Integer
		$qtys 		= $args[2]; // Array
		$lot_no 	= $args[3]; // String
		$unit 		= $args[4]; // String
		$c_id 		= $args[5]; // Integer
		$pattern 	= $args[6]; // Integer
		$code 		= $args[7];
		$code_prefix= $args[8];
		$code_number= $args[9];*/
		extract($data);

		$ex = new \App\Export;
		$ex->lot_number = $lot_no;
		$ex->code_id 		= $code_id;
		$ex->unit_id 		= $unit;
		$ex->order_id 		= $order_id;
		$ex->created_by 	= Auth::id();
		if ($pattern === '1') {
			$ex->qtys = array_sum($qtys);
			$ex->detail = join(',', $qtys);
		}
		else{
			$ex->qtys = $qtys;
		}
		$res = $ex->save(); 
		return $res;
	}

	protected function updateExportedOrder($id){
		$od = \App\Order::find($id);
		$od->status = 'success';
		$res = $od->save();
		return $res;
	}

	protected function makeExportedInvoice($customer_id,$export_id,$total,$refcode){
		$iv = new \App\Invoice;
		$iv->export_id = $export_id;
		$iv->customer_id = $customer_id;
		$iv->total = $total;
		$iv->refcode = $refcode;
		$res = $iv->save();	
		return $res;
	}

	protected function updateExportedStock($p_id,$p_color,$lot_detail){
		// pattern $lot_detail = "12=25,13=30"
		$lot_detail_arr = explode(',',$lot_detail);
		foreach ($lot_detail_arr as $detail) {

			$exported_lot 	= explode('=',$detail)[0];
			$exported_qtyp 	= explode('=',$detail)[1];
			$st = \App\Stock::where([
				[ 'product_id','=', $p_id ],
				[ 'lot_number','=', $exported_lot]
			])->first();
			$st->qtyp -= $exported_qtyp;
			$st->save();
			$st_color_detail = \App\StockPColorDetail::where([
				'stock_id' => $st->id,
				'color_code' => $p_color
			])->first();
			$st_color_detail->qtyp = $st_color_detail->qtyp - $exported_qtyp;
			$st_color_detail->save();
		}
	}


	protected function generateCode(){
		
	}


	protected function generateExportCode(){
		$number = $this->getLastExportNumber();
		$prefix = $this->getExportCodePrefix();
		$length = $this->getExportCodeLength();
		$new_number = sprintf('%0'.$length.'d', $number + 1);
		$code = $prefix.$new_number;
		return $code;
	}

	protected function getLastExportNumber(){
		$export_number =  \App\Export::where('code_prefix',$this->getExportCodePrefix())
		->orderBy('id','desc')->limit(1)->value('code_number');
		return ($export_number === null) ? 0 : $export_number;
	}

	protected function getExportCodePrefix(){
		if(Auth::user()->role === 'ext_minor'){
			$prefix = appconfig('ex_minor_prefix');
		}
		else{
			$prefix = appconfig('ex_major_prefix');
		}
		return $prefix;
	}

	protected function getExportCodeLength(){
		if(Auth::user()->role === 'ext_minor'){
			$length = appconfig('ex_minor_length');
		}
		else{
			$length = appconfig('ex_major_length');
		}
		return $length;
	}

}
