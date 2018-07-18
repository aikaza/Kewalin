<?php 


namespace App\Traits;
use DataTables;
trait InvoiceTrait{


	protected function summary(){
		$summary = \App\Invoice::join('exports','exports.id','invoices.export_id')
		->join('orders','orders.id','exports.order_id')
		->select(\DB::raw('SUM(total) as total,invoices.customer_id'))
		->groupBy('invoices.customer_id')->get();
		return $summary;
	}

	protected function invoicesByCustomer($customer_id){
		$iv = $this->iv->where('customer_id',$customer_id)->get();
		return $iv;
	}

	protected function getDebtList($customer_id){
		$dl = \App\DebtBill::where([
			'customer_id' => $customer_id,
			'status' => 'pending'
		])->get();
		return $dl;
	}



}