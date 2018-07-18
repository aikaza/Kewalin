<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ExportTrait;
use App\Http\Requests\StoreExport;
use App\Traits\Excel\MakeInvoiceExel;
use App\Http\Requests\StoreExportPrice;
use App\Classes\ExportPriceBuilder;
use App\Classes\CodeGenerator;
use App\Classes\ExportBuilder;



class ExportController extends Controller
{
    use ExportTrait,MakeInvoiceExel;

    private $ex;

    public function __construct(\App\Export $ex){
        $this->ex = $ex;
        $this->middleware('canAccess:acm,admin',['only' => ['index','showInsertPrice','insertPrice','detailWithPrice']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('export.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($code_id, $pattern)
    {
        $data = \App\Order::where('code_id',$code_id)->get();
        $tosend = [
            'data'  => $data
        ];
        if($pattern === '1')
            return view('export.create',$tosend);
        else
            return view('export.create-2',$tosend);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function preCreate(Request $rq,$pattern)
    {
        $input = $rq->all();
        $tosend = [
            'input'  => $input,
            'pattern' => $pattern
        ];
        return view('export.pre-create',$tosend);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $rq)
    {
        ini_set('memory_limit', '2048M');
        return dbAction(function() use($rq){
            extract($rq->all());
            $input = unserialize(base64_decode($input));
            extract($input);
            $data = [
                'arr_order_id' => $order_id,
                'arr_product_id' => $p_id,
                'arr_product_color' => $p_color,
                'arr_qtyp' => $qtyp,
                'arr_qtys' => $qtys,
                'arr_lot_number' => $lot_no,
                'unit_id' => $unit,
                'customer_id' => $c_id,
                'pattern' => $pattern
            ];
            $exb = new ExportBuilder;
            $exb->setData($data);
            $exb->make();
            return redirect()->route('orders.index');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function show(Export $export)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function edit(Export $export)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Export $export)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function destroy(Export $export)
    {
        //
    }

    public function showInsertPrice($code_id){
        $ex = \App\Export::whereHas('order', function($q) use($code_id){
            $q->where('code_id',$code_id);
        })->where('complete','no')->get();
        $tosend = [
            'ex'    => $ex,
            'code_id' => $code_id
        ];
        return view('export.insert-price',$tosend);
    }

    public function insertPrice(StoreExportPrice $rq){
        return dbAction(function() use ($rq){
            extract($rq->all());
            $expb = new ExportPriceBuilder;
            $expb->setData($id, $qtys, $price);
            $expb->make();
            return redirect()->route('exports.index');
        },'ทำรายการเรียบร้อยแล้ว');
    }

    public function detail($code_id){
        $ex = \App\Export::whereHas('order', function($q) use($code_id){
            $q->where('code_id',$code_id);
        })->get();
        $tosend = [ 'exports' => $ex ];
        return view('order.detail', $tosend);
    }


    public function detailWithPrice($code_id){
        $ex = \App\Export::whereHas('order', function($q) use($code_id){
            $q->where('code_id',$code_id);
        })->get();
        $tosend = [ 'exports' => $ex ];
        return view('export.detail', $tosend);
    }

}
