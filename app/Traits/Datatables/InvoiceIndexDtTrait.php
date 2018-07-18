<?php 

namespace App\Traits\Datatables;

use DataTables;

trait InvoiceIndexDtTrait{


	public function InvoiceIndexDt(){
		/*$iv = \DB::select('
			SELECT CONCAT(\'<a href="invoices/detail/\',CAST(c.id as CHAR(50)),\'">\',CAST(SUM(iv.total) as CHAR(50)),\'</a>\') as total,
				CONCAT(c.first_name, \' \', c.last_name) as customer,
				iv.customer_id customer_id
			FROM invoices iv 
			INNER JOIN exports ex on ex.id = iv.export_id
			INNER JOIN orders od on od.id = ex.order_id
			INNER JOIN customers c on c.id = iv.customer_id
			GROUP BY customer_id
			Having SUM(iv.total) > 0
			');*/
			$iv = \DB::select("
				SELECT c.id customer_id , 
				CONCAT(c.first_name, ' ', c.last_name ) customer, 
				COALESCE(SUM(d.total_debt),0) total,
				MAX(d.updated_at) date
				FROM customers c 
				LEFT JOIN (SELECT * FROM debtbills WHERE status = 'pending')d ON d.customer_id = c.id
				GROUP BY c.id
				ORDER BY date DESC
				");
			return DataTables::of($iv)
			->addIndexColumn()
			->editColumn('total',function($iv){
				return '<a href="'.route('invoices.detail',$iv->customer_id).'">'.'	&#3647; '. number_format($iv->total,2).'</a>';
			})
			->editColumn('customer',function($iv){
				return '<a href="'.route('customers.detail',$iv->customer_id).'">'.$iv->customer.'</a>';
			})
			->addColumn('action',function($iv){
				return '<a style="cursor:pointer;text-decoration:none;" class="text-primary action status-update" href="'.route('bill.paid.list',$iv->customer_id).'">รายการชำระ</a> | <a style="cursor:pointer;text-decoration:none;" class="text-primary action status-update" href="'.route('invoices.listbill',$iv->customer_id).'">รายการบิล</a> | &ensp;<a class="text-primary make-bill" href="'.route('makebill',$iv->customer_id).'">ทำใบวางบิล</a>';
			})
			->rawColumns(['action','total','customer'])
			->toJson();
		}	


	}