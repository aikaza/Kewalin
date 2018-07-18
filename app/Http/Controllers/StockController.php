<?php

namespace App\Http\Controllers;

use App\Classes\StockBuilder;
use App\Http\Requests\StoreStock;
use App\Traits\StockTrait;
use Illuminate\Http\Request;

class StockController extends Controller
{
    use StockTrait;

    private $st;

    public function __construct(\App\Stock $st)
    {
        $this->st = $st;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tosend = [
            'min_pd_id'             => $this->minProductId(),
            'max_pd_id'             => $this->maxProductId(),
            'min_pd_remain'         => 0,
            'max_pd_remain'         => $this->maxProductRemain(),
            'show_cri_products'     => 'false',
            'show_remain_products'  => 'false',
            'show_outdate_products' => 'false',
        ];
        return view('stock.index', $tosend);
    }

    public function indexForCriProducts()
    {
        $tosend = [
            'min_pd_id'             => $this->minProductId(),
            'max_pd_id'             => $this->maxProductId(),
            'min_pd_remain'         => $this->minProductRemain(),
            'max_pd_remain'         => $this->maxProductRemain(),
            'show_cri_products'     => 'true',
            'show_remain_products'  => 'false',
            'show_outdate_products' => 'false',
        ];
        return view('stock.index', $tosend);
    }

    public function indexForRemainProducts()
    {
        $tosend = [
            'min_pd_id'             => $this->minProductId(),
            'max_pd_id'             => $this->maxProductId(),
            'min_pd_remain'         => $this->minProductRemain(),
            'max_pd_remain'         => $this->maxProductRemain(),
            'show_cri_products'     => 'false',
            'show_remain_products'  => 'true',
            'show_outdate_products' => 'false',
        ];
        return view('stock.index', $tosend);
    }

    public function indexForOutdateProducts()
    {
        $tosend = [
            'min_pd_id'             => $this->minProductId(),
            'max_pd_id'             => $this->maxProductId(),
            'min_pd_remain'         => $this->minProductRemain(),
            'max_pd_remain'         => $this->maxProductRemain(),
            'show_cri_products'     => 'false',
            'show_remain_products'  => 'false',
            'show_outdate_products' => 'true',
        ];
        return view('stock.index', $tosend);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lot_no = $this->st->max('lot_number') + 1;
        $tosend = [
            'lot_no' => $lot_no,
        ];
        return view('stock.create', $tosend);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStock $rq)
    {
        return dbAction(function () use ($rq) {
            extract($rq->all());
            $stb = new StockBuilder;
            $stb->setLotNumber($lot_no);
            $stb->setUnit($unit);
            $stb->setNote($note);
            $stb->setPrimaryData($p_code, $p_color, $qtyp, $qtys, $cst);
            $stb->make();
            return redirect()->route('stocks.index');
        }, 'เพิ่มสินค้าในสต็อกเรียบร้อยแล้ว');
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
    public function detail($id)
    {
        $tosend = [
            'pd' => \App\Product::find($id),
        ];
        return view('stock.detail', $tosend);
    }

    public function getProductAndLotDetail($product_id, $lot_number)
    {
        $st = \App\Stock::where([
            'product_id' => $product_id,
            'lot_number' => $lot_number,
        ])->first();
        $tosend = [
            'data'       => $st,
            'lot_number' => $lot_number,
            'product_id' => $product_id,
        ];
        return view('stock.product-lot-detail', $tosend);
    }

    public function getProductAndColorDetail($product_id)
    {

        $st     = \App\Stock::where('product_id', $product_id)->get();
        $tosend = [
            'data'       => $st,
            'product_id' => $product_id,
        ];
        return view('stock.product-color-detail', $tosend);
    }

    public function exportingLists($product_id)
    {

        $tosend = [
            'product_id' => $product_id,
        ];
        return view('stock.exporting-list-all', $tosend);
    }
    public function importingLists($product_id)
    {

        $tosend = [
            'product_id' => $product_id,
        ];
        return view('stock.importing-list-all', $tosend);
    }
}
