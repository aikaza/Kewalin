<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{

    public function index($type)
    {
        return view('report.' . $type . '.index');
    }

    public function create($type)
    {
        return view('report.' . $type . '.create');
    }

    public function generate(Request $rq, $type)
    {
        extract($rq->all());
        if ($type === 'sell') {
            if ($mode === 'all') {
                $result = \App\DebtBill::select('transactions.issue_date', 'debtbills.*')->leftJoin('transactions', 'transactions.debtbill_id', '=', 'debtbills.id')->with(['customer', 'code'])->whereRaw('date(debtbills.created_at) BETWEEN ? AND ?', array($date_start, $date_end))->get();
            } else {
                $result = \App\DebtBill::select('transactions.issue_date', 'debtbills.*')->leftJoin('transactions', 'transactions.debtbill_id', '=', 'debtbills.id')->with(['customer', 'code'])->whereRaw('date(debtbills.created_at) BETWEEN ? AND ? AND customer_id = ?', array($date_start, $date_end, $id_customer))->get();
            }
            if ($result->isEmpty()) {
                return response()->json([]);
            }
            $total  = \App\DebtBill::whereRaw('date(created_at) BETWEEN ? AND ?', array($date_start, $date_end))->sum('total_debt');
            $tosend = [
                'data'       => $result,
                'date_start' => $date_start,
                'date_end'   => $date_end,
                'total'      => $total,
            ];
            $file_name = $this->getFileName();
            $file_path = storage_path('report/' . $file_name);
            $pdf       = PDF::loadView('report.sell.template', $tosend);
            $pdf->save($file_path);
        }
        else{
            if ($mode === 'by_product') {
                $result = \App\Import::with(['product', 'unit'])->whereRaw('date(created_at) BETWEEN ? AND ? AND product_id = ?', array($date_start, $date_end, $product_id))->get();
            } else {
                $result = \App\Import::with(['product', 'unit'])->whereRaw('date(created_at) BETWEEN ? AND ?', array($date_start, $date_end))->get();
            }
            if ($result->isEmpty()) {
                return response()->json([]);
            }
            $total  = \App\Import::whereRaw('date(created_at) BETWEEN ? AND ?', array($date_start, $date_end))->sum('total_cost');
            $tosend = [
                'data'       => $result,
                'date_start' => $date_start,
                'date_end'   => $date_end,
                'total'      => $total,
            ];
            $file_name = $this->getFileName();
            $file_path = storage_path('report/' . $file_name);
            $pdf       = PDF::loadView('report.buy.template', $tosend);
            $pdf->save($file_path);
        }

        $report             = new \App\Report;
        $report->date_start = $date_start;
        $report->date_end   = $date_end;
        $report->note       = $note;
        $report->path       = $file_name;
        $report->type       = $type;
        $report->save();

        return response()->json([
            'file_name' => $file_name,
            'file_path' => $file_path,
        ]);
    }

    private function getFileName()
    {
        return "report_" . uniqid() . '.pdf';
    }

    public function download($file_name)
    {
        return response()->download(storage_path('report/' . $file_name));
    }

}
