
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
$lot_and_qtyp = \App\Stock::select('lot_number','color_detail')->where([
'product_id' => $product_id,
'unit_id' => $unit_id,
])->where('qtyp','>',0)
->whereRaw('INSTR(color_detail, '.$product_color.') > 0')
->get();
$lot_and_qtyp = $lot_and_qtyp->toArray();
if(!empty($lot_and_qtyp)){
$order_qtyp_remain = (int)$order_qtyp;
$available_lot_and_qtyp = [];
foreach ($lot_and_qtyp as $index => $value) {
foreach (explode(',',$value['color_detail']) as $key => $detail) {
$color = explode('=',$detail)[0];
$qtyp_in_stock = (int) explode('=',$detail)[1];
if($color == $product_color){
if ($qtyp_in_stock - $order_qtyp_remain >= 0) {
$available_lot_and_qtyp[$value['lot_number']] = $order_qtyp_remain;
$order_qtyp_remain = 0;
break;
}
else{
$available_lot_and_qtyp[$value['lot_number']] = $qtyp_in_stock;
$order_qtyp_remain = $order_qtyp_remain - $qtyp_in_stock;
}
}
}
}
return ($order_qtyp_remain == 0) ? $available_lot_and_qtyp : null;
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
