<?php

use Illuminate\Http\Request;

include_once 'initcon.php';

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});


/**
* Route group for autocomplete
*
*/
Route::group(['prefix' => 'sgt'], function(){
	Route::get('color','API\SuggestionController@sgtColor');
	Route::get('product','API\SuggestionController@sgtProduct');
	Route::get('product/code','API\SuggestionController@sgtProductCode');
	Route::get('customer','API\SuggestionController@sgtCustomer');
	Route::get('export/code', 'API\SuggestionController@sgtExportCode');
});


/**
* Route group for datatables
*
*/
Route::group(['prefix' => 'dt'], function(){
	Route::get('stock', __dt__('StockIndexDt'));
	Route::get('order', __dt__('OrderIndexDt'));
	Route::get('export', __dt__('ExportIndexDt'));
	Route::get('return', __dt__('ReturnIndexDt'));
	Route::get('invoice', __dt__('InvoiceIndexDt'));
	Route::get('product', __dt__('ProductIndexDt'));
	Route::get('customer', __dt__('CustomerIndexDt'));
	Route::get('report/{type}', __dt__('ReportIndexDt'));
	Route::get('bill/{customer_id}/list', __dt__('BillListDt'));
	Route::get('debt/{customer_id}/list', __dt__('DebtListDt'));
	Route::get('export/{product_id}/list', __dt__('ExportListDt'));
	Route::get('import/{product_id}/list', __dt__('ImportListDt'));
	Route::get('bill/paid/{customer_id}/list', __dt__('BillPaidListDt'));
	Route::get('exportbill/{customer_id}/list', __dt__('ExportBillListDt'));
});


/**
* Route group for common
*
*/
Route::get('customer/{id}/get','API\CommonController@getCustomer');
Route::get('color/{name}/check','API\CommonController@checkColor')->where('name', '(.*)');
Route::get('product/{code}/check','API\CommonController@checkProduct');
Route::get('export/{code}/get','API\CommonController@getExport');
Route::get('bill/{code}/get','API\CommonController@getBillExportList');

