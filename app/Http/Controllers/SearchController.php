<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
class SearchController extends Controller
{
	public function stockSearch(Request $rq){

		$pd = \DB::select($rq->sqlString);
		return \DataTables::of($pd)
		->addColumn('action', function ($pd) {
			$str = '';
			$str .= '<a href="'.route('stock.detail',$pd->p_id).'" class="btn btn-link">';
			$str .= 'รายละเอียด</a>';
			return   $str; 
		})
		->rawColumns(['p_lotnumber','p_image','action','p_status'])
		->toJson();
	}

	public function orderSearch(Request $rq){
		$od = \DB::select($rq->sqlString);
		return \DataTables::of($od)
		->addIndexColumn()
		->addColumn('action', function ($od) {
			$str = '';
			if($od->statusval === 'prepare'){
				$str .= '<a href="'.route('export.order.form',$od->refcode).'" class="btn btn-link text-success">';
				$str .= 'นำออก</a>|';
			}
			$str .= '<a href="#" class="btn btn-link text-primary">';
			$str .= 'รายละเอียด</a>|';
			$str .= '<a href="'.route('order.cancel',$od->refcode).'" class="btn btn-link text-danger">';
			$str .= 'ยกเลิกรายการ</a>';
			return   $str; 
		})
		->rawColumns(['product','qtyp','status','action'])
		->toJson();
	}
}
