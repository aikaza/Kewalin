<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuggestionController extends Controller
{



	/**
    * Get the suggestions from storage for auto-complete.
    *
    * @return \Illuminate\Http\Response(JSON)
    */
	public function sgtExportCode(){
		$order_codes = \App\Export::distinct()->with('code')->get()->pluck('code.code');
		$suggestions = [];
		foreach ($order_codes as $order_code) {
			$object = (object)[
				'value' => $order_code,
				'data' => $order_code
			];
			array_push($suggestions, $object);
		}

		$data = (object) ['suggestions' => $suggestions];
		return response()->json($data);
	}




	/**
    * Get the suggestions from storage for auto-complete.
    *
    * @return \Illuminate\Http\Response(JSON)
    */
	public function sgtColor(){
		$color_from_stock = \App\Import::pluck('product_color')->toArray();
		$colors = array_unique($color_from_stock);
		$suggestions = [];
		foreach ($colors as $color) {
			$object = (object)[
				'value' => $color,
				'data' => $color
			];
			array_push($suggestions, $object);
		}
		$data = (object) ['suggestions' => $suggestions];
		return response()->json($data);
	}




	/**
    * Get the suggestions from storage for auto-complete.
    *
    * @return \Illuminate\Http\Response(JSON)
    */
	public function sgtProduct(){
		$pd = \App\Product::orderBy('code')->get();
		$suggestions = [];
		foreach ($pd as $key => $value) {
			$object = (object)[
				'value' => '#'.$value->code.' | '.$value->name,
				'data' => $value->id
			];
			array_push($suggestions, $object);
		}

		$data = (object) ['suggestions' => $suggestions];
		return response()->json($data);
	}




	/**
    * Get the suggestions from storage for auto-complete.
    *
    * @return \Illuminate\Http\Response(JSON)
    */
	public function sgtProductCode(){
		$pd = \App\Product::orderBy('code')->get();
		$suggestions = [];
		foreach ($pd as $key => $value) {
			$object = (object)[
				'value' => $value->code,
				'data' => $value->id
			];
			array_push($suggestions, $object);
		}

		$data = (object) ['suggestions' => $suggestions];
		return response()->json($data);
	}	




	/**
    * Get the suggestions from storage for auto-complete.
    *
    * @return \Illuminate\Http\Response(JSON)
    */
	public function sgtCustomer(){
		$ct = \App\Customer::select('id','first_name','last_name')->get();
		$suggestions = [];
		foreach ($ct as $key => $value) {
			$object = (object)[
				'value' => '#'.$value->id.' | '.$value->first_name.' '.$value->last_name,
				'data' => $value->id
			];
			array_push($suggestions, $object);
		}
		$data = (object) ['suggestions' => $suggestions];
		return response()->json($data);
	}

	
}
