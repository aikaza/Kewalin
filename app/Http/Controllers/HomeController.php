<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Stock;
use Illuminate\Support\Facades\DB;
use Excel;
use App\Exports\InvoicesExport;
class HomeController extends Controller
{

    public function __construct(){
        $this->middleware('canAccess:admin',['except' => ['setLanguage']]);
    }



    public function index()
    {
        $toSend = [
            'new_orders' => $this->newOrderCount(),
            'cri_products' => $this->criProductCount(),
            'outdate_products' => $this->outdateProductCount(),
            'remain_products' => $this->remainProductCount(),
            'total_products' => $this->totalProductCount(),
            'total_customers' => $this->totalCustomerCount(),
            'new_orders_this_week' => $this->newOrderCountThisWeek(),
            'remain_products_this_week' => $this->remainProductCountThisWeek(),
            'total_products_this_week' => $this->totalProductCountThisWeek(),
            'total_customers_this_week' => $this->totalCustomerCountThisWeek(),
            'seven_most_exporting'  => $this->sevenMostExporting(),
            'seven_most_customers_support' => $this->sevenMostCustomersSupport(),
            'seven_most_importing' => $this->sevenMostImporting(),
            'import_count_for_this_month' => $this->importCountForThisMonth(),
            'export_count_for_this_month' => $this->exportCountForThisMonth(),
            'cost_count_for_this_month' => $this->costCountForThisMonth(),
            'income_count_for_this_month' => $this->incomeCountForThisMonth()
        ];
        return view('index',$toSend);

    }



    private function newOrderCount(){
        return Order::where('status','prepare')->count(\DB::raw('DISTINCT(code_id)'));
    }

    private function criProductCount(){
        $cri_product_count =  DB::select(
            'SELECT COUNT(id) AS count FROM 
            ( SELECT DISTINCT p.id FROM products p LEFT JOIN stocks s ON s.product_id = p.id 
            GROUP BY p.id
            HAVING(COALESCE(SUM(s.qtyp),0) <= :cripoint )) AS result
            LIMIT 1',['cripoint' => appconfig('cripoint')]);
        if($cri_product_count[0]->count === null) return 0;
        return $cri_product_count[0]->count;
    }

    private function outdateProductCount(){
        $outdate_product_count =  DB::select(
            'SELECT COUNT(product_id) AS count FROM ( SELECT DISTINCT s.product_id FROM stocks s INNER JOIN products p ON s.product_id = p.id WHERE TO_DAYS(s.created_at) <= TO_DAYS(NOW()) - :outdatedr AND qtyp > 0) As result LIMIT 1', ['outdatedr' => appconfig('outdatedr')]);
        if($outdate_product_count[0]->count === null) return 0;
        return $outdate_product_count[0]->count;
    }

    private function remainProductCount(){
        $remain_product_count = DB::select(
            '   SELECT SUM(s.qtyp) as count FROM stocks s 
            INNER JOIN products p ON s.product_id = p.id 
            LIMIT 1     '
        );
        if($remain_product_count[0]->count === null) return 0;
        return $remain_product_count[0]->count;
    }

    private function totalProductCount(){
        $total_product_count = \App\Product::count('id');
        return $total_product_count;
    }

    private function totalCustomerCount(){
        $total_customer_count = \App\Customer::count('id');
        return $total_customer_count;
    }

    public function setLanguage($language){
        session(['locale' => $language]);
        return redirect()->back();
    }

    private function newOrderCountThisWeek(){
        return Order::whereRaw('YEARWEEK(created_at,1) = YEARWEEK(NOW(),1)')->count(\DB::raw('DISTINCT(code_id)'));
    }

    private function remainProductCountThisWeek(){
        $remain_product_count_this_week = 
        Stock::whereRaw('YEARWEEK(created_at,1) = YEARWEEK(NOW(),1)')
        ->sum('qtyp');
        return $remain_product_count_this_week;
    }

    private function totalProductCountThisWeek(){
        $total_product_count_this_week = 
        \App\Product::whereRaw('YEARWEEK(created_at,1) = YEARWEEK(NOW(),1)')
        ->count('id');
        return $total_product_count_this_week;
    }


    private function totalCustomerCountThisWeek(){
        $total_customer_count_this_week = 
        \App\Customer::whereRaw('YEARWEEK(created_at,1) = YEARWEEK(NOW(),1)')
        ->count('id');
        return $total_customer_count_this_week;
    }

    private function sevenMostExporting(){
        $ex = \App\Export::join('orders','orders.id','exports.order_id')
        ->selectRaw(\DB::raw('orders.product_id as product_id,orders.product_color as p_color, SUM(orders.qtyp) as  qtyp '))
        ->groupBy('product_id','p_color')->orderBy('qtyp','desc')->limit(7)->get();
        return $ex;
    }

    private function sevenMostImporting(){
        $im = \App\Import::selectRaw(\DB::raw('product_id,product_color,SUM(qtyp) as  qtyp '))
        ->groupBy('product_id','product_color')->orderBy('qtyp','desc')->limit(7)->get();
        return $im;
    }

    private function sevenMostCustomersSupport(){
        $ex = \App\Export::join('orders','orders.id','exports.order_id')
        ->selectRaw(\DB::raw('orders.customer_id,SUM(orders.qtyp) as qtyp'))
        ->groupBy('orders.customer_id')->orderBy('qtyp','desc')->limit(7)->get();
        return $ex;
    }

    private function importCountForThisMonth(){
        return \App\Import::whereRaw('YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW())')->sum('qtyp');
    }

    private function exportCountForThisMonth(){
        return \App\Export::join('orders','orders.id','exports.order_id')
        ->whereRaw('YEAR(exports.created_at) = YEAR(NOW()) AND MONTH(exports.created_at) = MONTH(NOW())')
        ->sum('orders.qtyp');
    }

    private function costCountForThisMonth(){
        return \App\Import::selectRaw('coalesce(SUM(total_cost),0) as total')->whereRaw('YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW())')->first()->total;
    }

    private function incomeCountForThisMonth(){
        return \App\Export::join('orders','orders.id','exports.order_id')
        ->selectRaw('coalesce(SUM(orders.qtyp * exports.price_per_unit),0) as total')
        ->whereRaw('YEAR(exports.created_at) = YEAR(NOW()) AND MONTH(exports.created_at) = MONTH(NOW())')
        ->first()->total;
    }
}

