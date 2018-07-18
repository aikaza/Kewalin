@php
class StockChecking{

	private $product_id;
	private $product_color;
	private $qtyp;
	private $unit_id;
	private $result = [];

	public function __construct(array $product_id, array $product_color,array $qtyp, $unit_id){
		$this->product_id = $product_id;
		$this->product_color = $product_color;
		$this->qtyp = $qtyp;
		$this->unit_id = $unit_id;
	}


	private function getAvailableLotAndQtyp($product_id,$product_color,$order_qtyp,$unit_id){
		$response = \App\Stock::join('stock_pcolor_details','stocks.id','stock_pcolor_details.stock_id')
		->selectRaw('lot_number,stock_pcolor_details.qtyp as qtyp,color_code')
		->where([
			'product_id' => $product_id,
			'unit_id' => $unit_id,
			'color_code' => $product_color
		])
		->where('stocks.qtyp','>',0)
		->where('stock_pcolor_details.qtyp','>',0)
		->get();

		if(!$response->isEmpty()){
			$export_lot_arr = [];
			$export_qtyp_arr = [];
			$order_qtyp_remain = $order_qtyp;
			foreach ($response as $index => $data) {
				if($data->qtyp >= $order_qtyp_remain){
					array_push($export_lot_arr, $data->lot_number);
					array_push($export_qtyp_arr, $order_qtyp_remain);
					$order_qtyp_remain = 0;
					break;
				}
				else{
					array_push($export_lot_arr, $data->lot_number);
					array_push($export_qtyp_arr, $data->qtyp);
					$order_qtyp_remain -= $data->qtyp;	
				}
			}
			if($order_qtyp_remain === 0){
				$text = '';
				$text_arr = [];
				for ($i=0; $i < sizeof($export_lot_arr); $i++) { 
					$text = $export_lot_arr[$i].'='.$export_qtyp_arr[$i];
					array_push($text_arr, $text);
				}
				return implode(',', $text_arr);
			}
			else{
				return null;
			}
		}
		else{
			return null;
		}
	}


	public function calculate(){

		for ($i=0; $i < sizeof($this->product_id); $i++) { 
			$this->result[$i] = $this->getAvailableLotAndQtyp($this->product_id[$i],$this->product_color[$i],$this->qtyp[$i],$this->unit_id);
		}
		return $this->result;
	}
}
@endphp