<?php 

namespace App\Traits\Excel;

use Excel;

trait MakeInvoiceExel{


	protected function makeExportInvoice($customerData, $exportData, $code){
		$file_name = 'bill_'.$code;
		$file_path = 'bill/'.date('Y-m-d').'/'.$exportData[0]->order->refcode;
		Excel::load(storage_path('bill/form.xlsx'), function($reader) use ($customerData,$exportData,$code){ 
			$sheet = $reader->getSheetByName('บิลส่งของ');
			$sheet->setCellValue('C5', '*'.$customerData->get('id'));
			$sheet->setCellValue('C6', $customerData->get('name'));
			$sheet->setCellValue('C7', $customerData->get('address'));
			$sheet->setCellValue('C8', $customerData->get('phone'));
			$sheet->setCellValue('U2', $code);
			$sheet->setCellValue('U3', date('d.m.Y'));
			$sheet->setCellValue('U7', $exportData[0]->order->refcode);
			$sheet->setCellValue('B13', '*'.$exportData[0]->order->product->code.' '.$exportData[0]->order->product->name);

			$pColorCol = 'B';
			$pCountCol = 'O';
			$totalCol = 'S';
			$unitCol = 'U';
			$currentRow = 15;
			foreach ($exportData as $i => $data) {
				$sheet->setCellValue($pColorCol.$currentRow, '*'.($i+1).' '.$data->order->product_color);
				$sheet->setCellValue($pCountCol.$currentRow, $data->order->qtyp);
				$sheet->setCellValue($totalCol.$currentRow, $data->qtys);
				$sheet->setCellValue($unitCol.$currentRow, strtoupper($data->unit->prefix));

				if($data->detail !== null){
					$details = explode(',', $data->detail);
					foreach ($details as $i => $detail) {
						$cols = ['D','E','F','G','H','I','J','K','L','M'];
						$currentCol = $cols[ $i % 10];
						if ($i > 0 and $i % 10 === 0) {
							$currentRow++;
						}
						$sheet->setCellValue($currentCol.$currentRow, $detail);
					}
				}
				$currentRow = $currentRow + 2; 
			}
		})->setFilename($file_name)->store('xls',storage_path($file_path));
		$bill = new \App\Bill;
		$bill->filename = $file_name.'.xls';
		$bill->filepath = $file_path.'/'.$file_name.'.xls';
		$bill->ordercode = $exportData[0]->order->refcode;
		$bill->save();
	}


	protected function makeAccountInvoice($customerData, $exportData, $code){
		$file_name = 'bill_account';
		$file_path = 'bill/'.date('Y-m-d').'/'.$code;
		Excel::load(storage_path('bill/form.xlsx'), function($reader) use ($customerData,$exportData,$code){ 

			$sheet = $reader->getSheetByName('ใบวางบิล');
			$sheet->setCellValue('B6', '*'.$customerData->get('id'));
			$sheet->setCellValue('B7', $customerData->get('name'));
			$sheet->setCellValue('B8', $customerData->get('address'));
			$sheet->setCellValue('B9', $customerData->get('phone'));
			$sheet->setCellValue('T1', $exportData[0]->order->bill_refcode);
			$sheet->setCellValue('T3', date('d.m.Y'));
			
			$noCol = 'A';
			$noExportCol = 'B';
			$dateExportCol = 'C';
			$pListCol = 'D';
			$qtypCol = 'J';
			$qtysCol = 'K';
			$unitCol = 'M';
			$priceCol = 'N';
			$totalPriceCol = 'T';
			$currentRow = 14;
			foreach ($exportData as $i => $data) {
				$sheet->setCellValue($noCol.$currentRow, $i+1);
				$sheet->setCellValue($noExportCol.$currentRow, $data->code);
				$sheet->setCellValue($dateExportCol.$currentRow, explode(' ', $data->created_at)[0]);
				$sheet->setCellValue($pListCol.$currentRow, '*'.$data->order->product->code.' '.$data->order->product->name);
				$sheet->setCellValue($qtypCol.$currentRow, $data->order->qtyp);
				$sheet->setCellValue($qtysCol.$currentRow, $data->qtys);
				$sheet->setCellValue($unitCol.$currentRow, strtoupper($data->unit->prefix));
				$sheet->setCellValue($priceCol.$currentRow, $data->price_per_unit);
				$sheet->setCellValue($totalPriceCol.$currentRow, $data->total_price);
				$currentRow++; 
			}
		})->setFilename($file_name)->store('xlsx',storage_path($file_path));

		$bill = new \App\Bill;
		$bill->filename = $file_name.'.xlsx';
		$bill->filepath = $file_path.'/'.$file_name.'.xlsx';
		$bill->type = 'account';
		$bill->ordercode = $code;
		$bill->save();
	}


	protected function makeInvoice($data){
		$file_name = uniqid('bill_',true);
		Excel::load('/home/hadoop/Downloads/form.xls', function($reader) use ($data) { 
			$sheet = $reader->getSheetByName('บิลส่งของ');
			$sheet->setCellValue('U3','TEST DATA');
			$sheet->setCellValue('U6',$data->get('date'));
			$sheet->setCellValue('C10','*'.$data->get('customer')['id']);
			$sheet->setCellValue('C11',$data->get('customer')['name']);
			$sheet->setCellValue('C12',$data->get('customer')['phone']);
			$sheet->setCellValue('C13',$data->get('customer')['address']);
		})->setFilename($file_name)->store('xls');
	}


	protected function getCustomer($id){
		$customer_info = \App\Customer::find($id)->toArray();
		$customer_data = collect([]);
		$customer_data->put('id',$customer_info['id']);
		$customer_data->put('name',$customer_info['first_name'].' '.$customer_info['last_name']);
		$customer_data->put('phone',$customer_info['phone_no']);
		$customer_data->put('address',$customer_info['address']);
		return $customer_data;
	}

	private function provideDataForExport($export_code){
		$export_info = \App\Export::where('code_id',$export_code)->get();
		return $export_info;
	}	



}