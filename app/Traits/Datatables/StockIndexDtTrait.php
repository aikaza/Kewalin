<?php 

namespace App\Traits\Datatables;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
trait StockIndexDtTrait{



	public function StockIndexDt(Request $rq){

		$pd = \DB::select($rq->sqlString);

		return DataTables::of($pd)
		->editColumn('p_code','#{{$p_code}}')
		->addColumn('action', function ($pd) {
			$str = '';
			$str .= '<a href="'.route('stocks.detail',$pd->p_id).'" class="btn btn-link">';
			$str .= 'รายละเอียด</a>';
			return   $str; 
		})
		->editColumn('qtyp',function($pd){
			$str = '<a href="'.route('stocks.product.color.detail',$pd->p_id).'">';
			$str .= $pd->qtyp;
			$str .= '</a>';
			return $str;
		})
		->editColumn('p_image', function($pd){
			$str = '';
			if($pd->p_image !== 'ไม่มี'){
				$gallery_name = str_random(6);
				foreach (explode(',',$pd->p_image) as $path) {
					$str .= '<a href="'.Storage::url($path).'" data-toggle="lightbox" data-gallery="'.$gallery_name.'" data-type="image"">';
					$str .= '<img width="50" height="50" src="'.Storage::url($path).'">';
					$str .= '</a>';
				}
			}
			else $str = $pd->p_image;
			return $str;
		})
		->rawColumns(['p_lotnumber','p_image','action','p_status','qtyp'])
		->toJson();
	}




}