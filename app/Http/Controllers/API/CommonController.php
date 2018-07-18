<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{


	/**
    * Get the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response(JSON)
    */
	public function getCustomer($id)
	{
		$ct = \App\Customer::find($id);
		return response()->json($ct);
	}



    /**
    * Get the specified resource from storage.
    *
    * @param  String  $name
    * @return \Illuminate\Http\Response(JSON)
    */
    public function checkColor($name)
    {
        $res = \App\Import::where('product_color',$name)->first();
        $res = ($res === null) ? false : true;
        return response()->json($res);
    }



	/**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function checkProduct($code)
    {
        $pd = \App\Product::where('code',$code)->first();
        $pd = ($pd === null) ? [] : $pd->toArray();
        $result = (!empty($pd)) ? true : false;
        return response()->json($result);
    }




    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function getExport($code)
    {
        $data = \DB::select("
            SELECT CONCAT(p.code,' ', p.name) product, CONCAT(c.first_name,' ',c.last_name) customer, o.product_color product_color, o.qtyp qtyp, UPPER(u.prefix) unit
            FROM exports e 
            INNER JOIN orders o ON o.id = e.order_id
            INNER JOIN products p ON p.id = o.product_id
            INNER JOIN customers c ON c.id = o.customer_id
            INNER JOIN codes cd ON cd.id = e.code_id
            INNER JOIN units u ON u.id = e.unit_id
            WHERE o.status = 'success' AND cd.code = ?
        ",[$code]);
        return response()->json($data);
    }


    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function getBillExportList(Request $rq, $code_id){
        $data = \App\Bill::where('code_id', $code_id)->get();
        return $data->toJson();
    }





}
