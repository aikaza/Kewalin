<?php

namespace App\Traits\Excel;

use Excel;

trait MakeInvoiceExport
{

    protected function makeInvoiceExport($data_customer, $data_export, $index = 1)
    {
        $file_path = 'bill/' . date('Y-m-d') . '/' . $data_export[0]->order->code->code.'_'.$index;
        $file_name = 'bill_' . $data_export[0]->code->code;
        /*if ($this->checkOverflow($data_export)) {
        $arr_file_data                = [];
        $arr_file_data['code_export'] = $data_export[0]->code->code;
        $arr_file_data['code_order']  = $data_export[0]->order->code->code;
        $arr_file_data['customer']    = $data_customer;
        $arr_file_data['product']     = '*' . $data_export[0]->order->product->code . ' ' . $data_export[0]->order->product->name;
        $current_row                  = 14;
        foreach ($data_export as $i => $data) {
        $current_row += 2;
        $arr_instance                   = array();
        $arr_instance['product_color']  = $data->order->product_color;
        $arr_instance['product_qtyp']   = $data->order->qtyp;
        $arr_instance['product_qtys']   = $data->qtys;
        $arr_instance['product_unit']   = strtoupper($data->unit->prefix);
        $arr_instance['product_detail'] = null;
        if ($data->detail !== null) {
        $arr_detail         = explode(',', $data->detail);
        $len_detail         = count($arr_detail);
        $count_row          = ceil($len_detail / 9);
        $arr_result         = [];
        $index              = 0;
        $arr_result[$index] = [];
        foreach ($arr_detail as $i => $detail) {
        if ($i % 9 === 0) {
        $current_row++;
        }
        if ($current_row > 32) {
        $current_row = 17;
        $index++;
        $arr_result[$index] = [];
        }
        array_push($arr_result[$index], $detail);
        }
        } else {

        }

        }

        Excel::load(storage_path('bill/บิลส่งของ 9x11.xlsx'), function ($reader) use ($data_customer, $data_export) {
        $sheet = $reader->getSheetByName('บิลส่งของ');
        $sheet->setCellValue('C6', 'overflow ');
        })->setFilename($file_name)->store('xlsx', storage_path($file_path));
        } else {*/
        Excel::load(storage_path('bill/บิลส่งของ 9x11.xlsx'), function ($reader) use ($data_customer, $data_export) {
            $sheet = $reader->getSheetByName('บิลส่งของ');
            $sheet->setCellValue('C6', '*' . $data_customer->get('id'));
            $sheet->setCellValue('C7', $data_customer->get('name'));
            $sheet->setCellValue('C8', $data_customer->get('address'));
            $sheet->setCellValue('C9', $data_customer->get('phone'));
            $sheet->setCellValue('Q3', $data_export[0]->code->code);
            $sheet->setCellValue('Q4', date('d.m.Y'));
            $sheet->setCellValue('Q8', $data_export[0]->order->code->code);
            $sheet->setCellValue('C13', '*' . $data_export[0]->order->product->code . ' ' . $data_export[0]->order->product->name);
            $total_qtyp = 0;
            $total_qtys = 0;
            $pColorCol  = 'C';
            $pCountCol  = 'N';
            $totalCol   = 'R';
            $unitCol    = 'S';
            $cols       = ['E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M'];
            $currentRow = 16;
            foreach ($data_export as $i => $data) {
                $sheet->setCellValue($pColorCol . $currentRow, $data->order->product_color);
                $sheet->setCellValue($pCountCol . $currentRow, $data->order->qtyp);
                $sheet->setCellValue($totalCol . $currentRow, $data->qtys);
                $sheet->setCellValue($unitCol . $currentRow, strtoupper($data->unit->prefix));
                $total_qtyp += $data->order->qtyp;
                $total_qtys += $data->qtys;

                if ($data->detail !== null) {
                    $details = explode(',', $data->detail);
                    foreach ($details as $i => $detail) {
                        $currentCol = $cols[$i % 9];
                        if ($i > 0 and $i % 9 === 0) {
                            $currentRow++;
                        }
                        $sheet->setCellValue($currentCol . $currentRow, $detail);
                    }
                    $currentRow = $currentRow + 2;
                } else {
                    $currentRow = $currentRow + 1;
                }

            }
        })->setFilename($file_name)->store('xlsx', storage_path($file_path));
        //}

        $bill           = new \App\Bill;
        $bill->filename = $file_name . '.xlsx';
        $bill->filepath = $file_path . '/' . $file_name . '.xlsx';
        $bill->code_id  = $data_export[0]->order->code->id;
        $bill->save();
    }

    private function getCustomerData($customer_id)
    {
        $customer_info = \App\Customer::find($customer_id)->toArray();
        $customer_data = collect([]);
        $customer_data->put('id', $customer_info['id']);
        $customer_data->put('name', $customer_info['first_name'] . ' ' . $customer_info['last_name']);
        $customer_data->put('phone', $customer_info['phone_no']);
        $customer_data->put('address', $customer_info['address']);
        return $customer_data;
    }

    private function getExportData($code_id)
    {
        $export_info = \App\Export::with(['unit', 'order'])->where('code_id', $code_id)->get();
        return $export_info;
    }

    private function writeCustomer($sheet, $data_customer)
    {
        $sheet->setCellValue('C5', '*' . $data_customer->get('id'));
        $sheet->setCellValue('C6', $data_customer->get('name'));
        $sheet->setCellValue('C7', $data_customer->get('address'));
        $sheet->setCellValue('C8', $data_customer->get('phone'));
    }

    private function checkOverflow($data)
    {
        $overflow   = false;
        $currentRow = 16;
        $len        = count($data);
        foreach ($data as $i => $d) {
            if ($d->detail !== null) {
                $details = explode(',', $d->detail);
                $currentRow += ceil(sizeof($details) / 9);
                if ($i !== $len - 1) {
                    $currentRow = $currentRow + 2;
                }
            } else {
                $currentRow = $currentRow + 1;
            }
            if ($currentRow > 32) {
                $overflow = true;
                break;
            }
        }
        return $overflow;
    }

}
