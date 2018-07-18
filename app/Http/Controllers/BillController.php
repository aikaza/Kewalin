<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\DebtBillMaker;


class BillController extends Controller
{



	public function download($path){
		$path = storage_path($path);
		return response()->download($path);
	}

	public function exportDebtBill(Request $rq, $customer_id){
		return dbAction(function() use($rq, $customer_id){
			$dbm = new DebtBillMaker;
			$dbm->setCustomer($customer_id);
			$dbm->setExportRefList($rq->export_codes);
			$dbm->make();
			return redirect()->route('invoices.index');
		}, 'ทำรายการเรียบร้อยแล้ว');
	}

	public function updateDebtStatus(Request $q){
		return dbAction(function() use ($q){
			extract($q->all());
			$debt = \App\DebtBill::where('code_id',$code_id)->first();
			$debt->status = 'paid';
			$debt->save();
			$trans = new \App\Transaction;
			$trans->bank = $bank;
			$trans->cheque_number = $cheque_number;
			$trans->issue_date = defaultEmpty($issue_date);
			$trans->note = defaultEmpty($note);
			$trans->debtbill_id = $debt->id;
			$trans->save();
			return redirect()->back();
		}, 'ทำรายการเรียบร้อยแล้ว');
	}

	public function getPaidList($customer_id){
		$tosend = [ 'customer' => \App\Customer::find($customer_id) ];
		return view('invoice.list-paid',$tosend);
	}	
}
