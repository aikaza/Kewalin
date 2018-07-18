<?php 

namespace App\Traits\Datatables;

use DataTables;

trait CustomerIndexDtTrait{


	public function CustomerIndexDt(){
		$ct = \DB::select('
			SELECT 	c.id as id, CONCAT(c.first_name, \' \', c.last_name) as name,
			c.alias_name as alias_name, c.email as email,
			c.phone_no as phone_no, c.address as address
			FROM customers c 
			');
		return DataTables::of($ct)
		->editColumn('name', function($ct){
			return '<a href="'.route('customers.detail',$ct->id).'">'.$ct->name.'</a>';
		})
		->addColumn('action', function ($ct) {
			$str =  '<a href="'.route('customers.edit',$ct->id).'" ';
			$str .= 'class="text-primary action">แก้ไขข้อมูล</a> &ensp;| &ensp; ';
			$str .= '<a href="'.route('customers.delete',$ct->id).'" class="text-danger action del-btn" c-id="'.$ct->id.'"> ';
			$str .= 'ลบรายการ</a>';
			return $str;    
		})
		->rawColumns(['action','name'])
		->toJson();
	}

}