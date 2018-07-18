<?php

namespace App\Traits\Excel;

use Excel;
use PHPExcel_Worksheet_PageSetup;

trait MakeInvoiceExport
{

    protected function makeInvoiceExport($data, $data_export, $index)
    {
        extract($data);
        $next_page = false;
        $file_path = 'bill/' . date('Y-m-d') . '/' . $code_order;
        $file_name = 'bill_' . $code_export . '_' . $index;
        Excel::load(storage_path('bill/บิลส่งของ 9x11.xlsx'), function ($reader) use ($data, &$data_export, &$next_page, &$index) {
            extract($data);
            $sheet = $reader->getSheetByName('บิลส่งของ');
            $sheet->setCellValue('C6', '*' . $customer_id);
            $sheet->setCellValue('C7', $customer_name);
            $sheet->setCellValue('C8', $customer_address);
            $sheet->setCellValue('C9', $customer_phone);
            $sheet->setCellValue('Q3', $code_export);
            $sheet->setCellValue('Q4', date('d.m.Y'));
            $sheet->setCellValue('Q8', $code_order);
            $sheet->setCellValue('C13', '*' . $product);
            $sheet->setCellValue('S33', $unit);
            $qtyp_ = 0;
            $qtys_ = 0;
            $pColorCol  = 'C';
            $pCountCol  = 'N';
            $totalCol   = 'R';
            $unitCol    = 'S';
            $cols       = ['E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M'];
            $currentRow = 16;
            foreach ($data_export as $i => $data) {
                $currentPrimaryRow = $currentRow;
                $sheet->setCellValue($pColorCol . $currentRow, $data->order->product_color);
                $sheet->setCellValue($unitCol . $currentRow, $unit);

                if ($data->detail !== null) {
                    if (!is_array($data->detail)) {
                        $details                 = explode(',', $data->detail);
                        $data_export[$i]->detail = $details;
                    }
                    $total_qtyp = 0;
                    $total_qtys = 0;
                    $data_detail_temp = $data->detail;
                    foreach ($data->detail as $j => $detail) {
                        $currentCol = $cols[$j % 9];
                        if ($j > 0 and $j % 9 === 0) {
                            $currentRow++;
                            if ($currentRow > 31) {
                                $next_page = true;
                                $index++;
                                $sheet->setCellValue($pCountCol . $currentPrimaryRow, $total_qtyp);
                                $sheet->setCellValue($totalCol . $currentPrimaryRow, $total_qtys);
                                $sheet->setCellValue('C14', 'ต่อใบที่'.$index);
                                break 2;
                            }
                        }
                        $sheet->setCellValue($currentCol . $currentRow, $detail);
                        array_splice($data_detail_temp, 0, 1);
                        $data_export[$i]->detail = $data_detail_temp;
                        $total_qtyp++;
                        $total_qtys += $detail;
                        $qtyp_++;
                        $qtys_ += $detail;
                    }
                    $sheet->setCellValue($pCountCol . $currentPrimaryRow, $total_qtyp);
                    $sheet->setCellValue($totalCol . $currentPrimaryRow, $total_qtys);
                    $currentRow = $currentRow + 2;
                    $currentPrimaryRow = $currentPrimaryRow + 2;
                } else {
                    $sheet->setCellValue($pCountCol . $currentRow, $data->order->qtyp);
                    $sheet->setCellValue($totalCol . $currentRow, $data->qtys);
                    $qtyp_ += $data->order->qtyp;
                    $qtys_ += $data->qtys;
                    $currentRow = $currentRow + 1;
                    $currentPrimaryRow = $currentPrimaryRow + 1;
                }

                $data_export->forget($i);

                if ($currentRow > 32) {
                    $next_page = true;
                    $index++;
                    $sheet->setCellValue('C14', 'ต่อใบที่'.$index);
                    break;
                }

            }
            if($index > 1 && !$next_page){
                $sheet->setCellValue('C14', 'ใบสุดท้ายที่'.$index);
            }

            $sheet->setCellValue('N33', $qtyp_);
            $sheet->setCellValue('Q33', $qtys_);
            $pageSetup = new PHPExcel_Worksheet_PageSetup;
            $pageSetup->setScale(33);
            $sheet->setPageSetup($pageSetup);

        })->setFilename($file_name)->store('xlsx', storage_path($file_path));
        $bill           = new \App\Bill;
        $bill->filename = $file_name . '.xlsx';
        $bill->filepath = $file_path . '/' . $file_name . '.xlsx';
        $bill->code_id  = $code_order_id;
        $bill->save();

        if ($next_page) {
            $this->makeInvoiceExport($data, $data_export, $index);
        }
    }


    private function getExportData($code_id)
    {
        $export_info = \App\Export::with(['unit', 'order'])->where('code_id', $code_id)->get();
        return $export_info;
    }

    private function getData($code_id)
    {
        $object = \DB::select("
			SELECT SUM(o.qtyp) qtyp, SUM(e.qtys) qtys, GROUP_CONCAT(DISTINCT ce.code) code_export, GROUP_CONCAT(DISTINCT co.code) code_order, GROUP_CONCAT(DISTINCT co.id) code_order_id, GROUP_CONCAT(DISTINCT CONCAT(p.code, ' ', p.name)) product, GROUP_CONCAT(DISTINCT UPPER(u.prefix)) unit,
			GROUP_CONCAT(DISTINCT c.id) customer_id, GROUP_CONCAT(DISTINCT CONCAT(c.first_name, ' ', c.last_name)) customer_name, GROUP_CONCAT(DISTINCT c.address) customer_address, GROUP_CONCAT(DISTINCT c.phone_no) customer_phone
			FROM exports e
			INNER JOIN orders o ON o.id = e.order_id
			INNER JOIN customers c ON c.id = o.customer_id
			INNER JOIN codes ce ON ce.id = e.code_id
			INNER JOIN codes co ON co.id = o.code_id
			INNER JOIN units u ON u.id = e.unit_id
			INNER JOIN products p ON p.id = o.product_id
			WHERE e.code_id = ?
    	", [$code_id]);

        $data = array_map(function ($object) {
            return (array) $object;
        }, $object);
        return $data[0];
    }


}
