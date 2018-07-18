<?php 

namespace App\Classes;

use Illuminate\Support\Facades\Auth;
use App\Traits\Excel\MakeInvoiceExport;

class ExportBuilder{

	use MakeInvoiceExport;

	protected $data;

	public function setData(array $data){
		$this->data = $data;
	}

	public function make(){
		extract($this->data);
		$arr_products = array_unique($arr_product_id);
		$arr_codes = array();
		foreach($arr_products as $index => $product_id){
			$_index = array_keys($arr_product_id, $product_id);
			$_code_id = $this->getCodeId();
			array_push($arr_codes, $_code_id);
			foreach($_index as $i){
				$data = [
					'order_id' => $arr_order_id[$i],
					'product_id' => $arr_product_id[$i],
					'product_color' => $arr_product_color[$i],
					'qtyp' => $arr_qtyp[$i],
					'qtys' => $arr_qtys[$i],
					'lot_number' => $arr_lot_number[$i],
					'code_id' => $_code_id,
					'unit_id' => $unit_id,
					'customer_id' => $customer_id,
					'pattern' => $pattern
				];
				$this->storeExport($data);
			}
		}
		$this->makeInvoice($customer_id, $arr_codes);
	}

	protected function storeExport(array $data){
		extract($data);
		$ex = new \App\Export;
		$ex->lot_number 	= $lot_number;
		$ex->code_id 		= $code_id;
		$ex->unit_id 		= $unit_id;
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
		if ($res) {
			$this->updateExportedOrder($order_id);
			$this->updateExportedStock($product_id, $product_color, $lot_number);
		} 
	}

	protected function updateExportedOrder($id){
		$od = \App\Order::find($id);
		$od->status = 'success';
		$res = $od->save();
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

	protected function getCodeId(){
		if (Auth::user()->role === 'ext_minor') {
			$prefix = appconfig('ex_minor_prefix');
			$length = appconfig('ex_minor_length');
		}
		else{
			$prefix = appconfig('ex_major_prefix');
			$length = appconfig('ex_major_length');
		}
		$code = new CodeGenerator($prefix, $length);
		$code->make();
		return $code->getId(); 
	}

	protected function makeInvoice($customer_id, array $arr_code){
		foreach ($arr_code as $code_id) {  
			$data_export = $this->getExportData($code_id);
			$data = $this->getData($code_id);
			$this->makeInvoiceExport($data, $data_export,1); 
		}
	}


}