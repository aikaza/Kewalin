<?php 

namespace App\Traits\Datatables;

use DataTables;
use Illuminate\Support\Facades\Storage;

trait ProductIndexDtTrait{


	public function ProductIndexDt(){
		$pd = \DB::select('
			SELECT p.id as id,p.code as code, p.name as name,
			CASE 
			WHEN GROUP_CONCAT(i.path) IS NULL THEN \'ไม่มี\'
			ELSE GROUP_CONCAT(i.path)
			END as image
			FROM products p LEFT JOIN images i ON p.id = i.product_id 
			GROUP BY p.id
			');
		return DataTables::of($pd)
		->editColumn('code','#{{$code}}')
		->editColumn('image',function($pd){
			$str = '';
			if($pd->image !== 'ไม่มี'){
				$gallery_name = str_random(6);
				foreach (explode(',',$pd->image) as $path) {
					$str .= '<a href="'.Storage::url($path).'" data-toggle="lightbox" data-gallery="'.$gallery_name.'" data-type="image"">';
					$str .= '<img width="50" height="50" src="'.Storage::url($path).'">';
					$str .= '</a>';
				}
			}
			else $str = $pd->image;
			return $str;
		})
		->addColumn('action', function ($pd) {
			$str =  '<a href="/products/'.$pd->id.'/edit" ';
			$str .= 'class="text-primary action">แก้ไขข้อมูล</a> &ensp;| &ensp; ';
			$str .= '<a href="'.route('products.delete',$pd->id).'" class="text-danger action del-btn" p-id="'.$pd->id.'"> ';
			$str .=  'ลบรายการ</a>';
			return $str;		
		})
		->rawColumns(['action','image'])
		->removeColumn('id')
		->toJson();
	}


}