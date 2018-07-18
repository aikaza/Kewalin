<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\InvoiceTrait;
class InvoiceController extends Controller
{
    use InvoiceTrait;

    private $iv;

    public function __construct(\App\Invoice $iv){
        $this->iv = $iv;
        $this->middleware('canAccess:acm');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tosend = [
            'ivs' => $this->summary()
        ];
        return view('invoice.index',$tosend);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($customer_id){
        $tosend = [
            'ivs'   => $this->invoicesByCustomer($customer_id),
            'customer' => \App\Customer::find($customer_id),
            'debt_lists' => $this->getDebtList($customer_id)
        ];
        return view('invoice.detail',$tosend);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function makeBill($customer_id){
        
        $tosend = [
            'customer' => \App\Customer::find($customer_id),
        ];

        return view('invoice.make-bill',$tosend);
    }

    public function getListBill($customer_id){
       $tosend = [ 'customer' => \App\Customer::find($customer_id) ];
       return view('invoice.list-bill',$tosend);
    }
}
