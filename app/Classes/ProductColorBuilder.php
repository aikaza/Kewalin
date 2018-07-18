<?php 


namespace App\Classes;


class ProductColorBuilder{


	protected $stock_id;
	protected $color_code;
	protected $qtyp;

	public function setData($stock_id, $color_code, $qtyp){
		$this->stock_id = $stock_id;
		$this->color_code = $color_code;
		$this->qtyp = $qtyp;
	}

	public function make(){
		$pclr = new \App\StockPColorDetail;
		$pclr->stock_id = $this->stock_id;
		$pclr->color_code = $this->color_code;
		$pclr->qtyp = $this->qtyp;
		$pclr->save();
	} 			


}