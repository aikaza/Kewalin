<?php

namespace App\Http\Controllers;


use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Traits\ProductTrait;
use App\Http\Requests\StoreProduct;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{



    use ProductTrait;



    public function index()
    {
        return view('product.index');
    }




    public function create()
    {
        return view('product.create');
    }




    public function store(StoreProduct $rq)
    {
        return dbAction(function() use($rq){
            $pd = new \App\Product;
            $pd->code = $rq->product_code;
            $pd->name = $rq->product_name;
            $pd->save();
            if (isset($rq->fileUpload) && !empty($rq->fileUpload)) {
                foreach ($rq->fileUpload as $img_path) {
                    $pdath = $img_path->store('upload_img','public');
                    $img = new \App\Image;
                    $img->path = $pdath;
                    $img->product_id = $pd->id;
                    $img->save();
                }
            }
            return redirect('/products/create');
        },"เพิ่มสินค้า $rq->product_code เรียบร้อยแล้ว.");
    }




    public function edit($id)
    {
        $pd = \App\Product::find($id);
        $tosend = [ 'pd' => $pd ];
        return view('product.edit',$tosend);
    }




    public function update(StoreProduct $rq, $id)
    {
        return dbAction(function() use ($rq, $id){
            $pd = \App\Product::find($id);
            $pd->code = $rq->product_code;
            $pd->name = $rq->product_name;
            $pd->save();
            return redirect()->route('products.index');
        },'อัพเดทรายการสินค้าเรียบร้อยแล้ว');
    }




    public function delete($id)
    {
        $tosend = [
            'pd'    =>  \App\Product::find($id),
            'import_data_count' => $this->countRecords($id,new \App\Import),
            'export_data_count' => $this->countRecords($id,new \App\Export,['orders','orders.id','exports.order_id']),
            'stock_data_count'  => $this->countRecords($id,new \App\Stock),
            'order_data_count'  => $this->countRecords($id,new \App\Order)
        ];
        return view('product.delete',$tosend);
    }




    public function destroy($id)
    {
        return dbAction(function() use ($id){
            $pd = \App\Product::find($id);
            $pd->delete();
            return redirect()->route('products.index');
        },'ลบสินค้าเรียบร้อยแล้ว');
    }

}
