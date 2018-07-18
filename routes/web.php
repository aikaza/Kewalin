<?php

include_once 'initcon.php';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes();


Route::middleware(['auth'])->group(function () {

    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/lang/{language}', 'HomeController@setLanguage')->name('setlocale');


    #CustomerController
    Route::group(['as' => 'customers.', 'prefix' => 'customers'], function () {
        Route::get('{id}/detail', __customer__('detail'));
        Route::get('{id}/delete', __customer__('delete'));
    });



    #ProductController
    Route::group(['as' => 'products.', 'prefix' => 'products'], function () {
        Route::get('{product}/delete', __product__('delete'));
    });


    #ConfigurationController
    Route::group(['as' => 'config.', 'prefix' => 'config'], function () {
        Route::get('index', __config__('index'));
        Route::put('update', __config__('update'));
    });


    #InvoiceController
    Route::group(['as' => 'invoices.', 'prefix' => 'invoices'], function () {
        Route::get('detail/{customer_id}', __invoice__('detail'));
        Route::get('bill/list/{customer_id}', __invoice__('getListBill', 'listbill'));
    });


    #OrderControlller
    Route::group(['as' => 'orders.', 'prefix' => 'orders'], function () {
        Route::get('cancel/{coce_id}', __order__('cancel'));
        Route::get('neworders', __order__('indexForNewOrders', 'new.orders'));
    });


    #ReportController
    Route::group(['as' => 'reports.', 'prefix' => 'reports'], function () {
        Route::get('index/{type}', __report__('index'));
        Route::get('create/{type}', __report__('create'));
        Route::post('generate/{type}', __report__('generate'));
        Route::get('download/{file_name}', __report__('download'));
    });


    #StockController
    Route::group(['as' => 'stocks.', 'prefix' => 'stocks'], function () {
        Route::post('export', __stock__('export'));
        Route::get('{id}/detail', __stock__('detail'));
        Route::get('export', __stock__('showExportForm', 'export.form'));
        Route::get('critical/products', __stock__('indexForCriProducts', 'cri.products'));
        Route::get('{product_id}/detail/exporting/list', __stock__('exportingLists', 'export.list'));
        Route::get('{product_id}/detail/importing/list', __stock__('importingLists', 'import.list'));
        Route::get('remain/products', __stock__('indexForRemainProducts', 'remain.products'));
        Route::get('outdate/products', __stock__('indexForOutdateProducts', 'outdate.products'));
        route::get('{product_id}/remain', __stock__('getProductAndColorDetail','product.color.detail'));
        route::get('{product_id}/remain/{lot_number}', __stock__('getProductAndLotDetail','product.lot.detail'));
    });


    #UnitController
    Route::group(['as' => 'units.', 'prefix' => 'units'], function () {
        Route::get('index', __unit__('index'));
        Route::post('store', __unit__('store'));
        Route::put('update', __unit__('update'));
    });


    #UserController
    Route::group(['as' => 'users.', 'prefix' => 'users'], function () {
        Route::put('account/{user_id}/update', __user__('changeName', 'update.name'));
        Route::put('password/{user_id}/change', __user__('changePassword', 'update.password'));
    });


    #ExportController
    Route::group(['as' => 'exports.', 'prefix' => 'exports'], function () {
        Route::get('/', __export__('index'));
        Route::post('order/store', __export__('store'));
        Route::get('/{code_id}/detail', __export__('detail'));
        Route::get('order/{refcode}/{paterrn}', __export__('create'));
        Route::post('order/pre/{pattern}', __export__('preCreate','pre'));
        Route::put('/price/insert', __export__('insertPrice','insert.price'));
        Route::get('/price/insert/{code_id}', __export__('showInsertPrice', 'show.insert.price'));
        Route::get('/{code_id}/detail/price', __export__('detailWithPrice','detail.price'));
    });

    Route::resources([
        'customers' => 'CustomerController',
        'products'  => 'ProductController',
        'stocks'    => 'StockController',
        'orders'    => 'OrderController',
        'invoices'  => 'InvoiceController',
        'returns'   => 'ReturnController',
        'users'     => 'UserController',
    ]);



    Route::get('bill/{path}/download', 'BillController@download')->where('path', '(.*)');
    Route::get('/{customer_id}/makebill', 'InvoiceController@makeBill')->name('makebill');
    Route::post('/{customer_id}/debt/export', 'BillController@exportDebtBill')->name('debtbill.make');
    Route::post('debt/paid', 'BillController@updateDebtStatus')->name('debt.paid');
    Route::get('/bill/paid/{customer_id}', 'BillController@getPaidList')->name('bill.paid.list');
    Route::get('/test', 'TestController@test');

});
