<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
class DatatableController extends Controller
{
    public function productAndColorRemain($product_id){
    	$st = \App\Stock::where('product_id',$product_id)->get();
    	return DataTables::collection($st)
    			->addIndexColumn()
    			->make(true);
    }

    public function productAndLotRemain(){

    }





}
