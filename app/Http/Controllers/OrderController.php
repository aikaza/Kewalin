<?php

namespace App\Http\Controllers;

use App\Classes\OrderBuilder;
use App\Http\Requests\EditOrder;
use App\Http\Requests\StoreOrder;
use App\Traits\Excel\MakeInvoiceExel;
use App\Traits\OrderTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use OrderTrait, MakeInvoiceExel;

    private $od;

    public function __construct(\App\Order $od)
    {
        $this->od = $od;

        $this->middleware('preventDobleSubmit', ['only' => ['store']]);
        $this->middleware('canAccess:rsb,ext_minor,ext_major,admin',['only' => ['index','indexForNewOrders']]);
        $this->middleware('canAccess:rsb,admin',['only' => ['create']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tosend = [
            'min_qtyp'       => $this->minQtyp(),
            'max_qtyp'       => $this->maxQtyp(),
            'show_new_order' => "false",
            'created_for'    => Auth::user()->role,
        ];
        return view('order.index', $tosend);
    }

    public function indexForNewOrders()
    {
        $tosend = [
            'min_qtyp'       => $this->minQtyp(),
            'max_qtyp'       => $this->maxQtyp(),
            'show_new_order' => "true",
            'created_for'    => Auth::user()->role,
        ];
        return view('order.index', $tosend);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $rq)
    {
        return dbAction(function () use ($rq) {
            extract($rq->all());
            $ob = new OrderBuilder;
            $ob->serializeData($c_id, $p_code, $p_color, $qtyp, $created_for);
            $ob->make();
            return redirect()->route('orders.index');
        }, 'เพิ่มรายการสั่งซื้อเรียบร้อยแล้ว');
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
    public function edit($code_id)
    {
        $data   = \App\Order::where('code_id', $code_id)->get();
        $code   = \App\Code::find($code_id);
        $tosend = [
            'data' => $data,
            'code' => $code->code,
        ];
        return view('order.edit', $tosend);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditOrder $rq, $order_number)
    {
        return dbAction(function () use ($rq, $order_number) {
            extract($rq->all());
            $len = count($order_id);
            for ($index = 0; $index < $len; $index++) {
                $order = \App\Order::find($order_id[$index]);
                $order->product_id    = \App\Product::where('code', $product_code[$index])->value('id');
                $order->product_color = $product_color[$index];
                $order->qtyp          = $product_qtyp[$index];
                $order->save();
            }
            return redirect()->route('orders.index');
        }, 'ทำรายการเรียบร้อยแล้ว');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($code_id)
    {
        $odrs = $this->od->where('code_id', $code_id)->delete();
    }

    public function cancel($code_id)
    {
        $odrs = $this->od->where('code_id', $code_id)->delete();
        return redirect()->route('orders.index');
    }
}
