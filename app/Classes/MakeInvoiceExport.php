<?php 

namespace App\Classes;




class MakeInvoiceExport{

	protected $id_customer;
	protected $id_code;
	protected $file_extension = 'xlsx';

	public function setCustomerId($id_customer){
		$this->id_customer = $id_customer;
	}

	public function setCodeId($id_code){
		$this->id_code = $id_code;
	}

	public function setFileExtension($file_extension){
		$this->file_extension = $file_extension;
	}

	protected function make(){
		$data_customer = $this->getCustomerData();
		$data_export = $this->getExportData();
		$file_name = 'bill_'.$data_export[0]->code->code;;
		$file_path = 'bill/'.date('Y-m-d').'/'.$data_export[0]->order->code->code;
		Excel::load(storage_path('bill/บิลส่งของ 9x11.xlsx'), function($reader) use ($data_customer,$data_export){ 
			$sheet = $reader->getSheetByName('บิลส่งของ');
			$sheet->setCellValue('C6', '*'.$data_customer->get('id'));
			$sheet->setCellValue('C7', $data_customer->get('name'));
			$sheet->setCellValue('C8', $data_customer->get('address'));
			$sheet->setCellValue('C9', $data_customer->get('phone'));
			$sheet->setCellValue('Q3', $data_export[0]->code->code);
			$sheet->setCellValue('Q4', date('d.m.Y'));
			$sheet->setCellValue('Q8', $data_export[0]->order->code->code);
			$sheet->setCellValue('C13', '*'.$data_export[0]->order->product->code.' '.$data_export[0]->order->product->name);

			$pColorCol = 'C';
			$pCountCol = 'N';
			$totalCol = 'R';
			$unitCol = 'S';
			$cols = ['E','F','G','H','I','J','K','L','M'];
			$currentRow = 16;
			foreach ($data_export as $i => $data) {
				$sheet->setCellValue($pCountCol.$currentRow, $data->order->qtyp);
				$sheet->setCellValue($totalCol.$currentRow, $data->qtys);
				$sheet->setCellValue($unitCol.$currentRow, strtoupper($data->unit->prefix));

				if($data->detail !== null){
					$details = explode(',', $data->detail);
					foreach ($details as $i => $detail) {
						$currentCol = $cols[ $i % 9];
						if ($i > 0 and $i % 9 === 0) {
							$currentRow++;
						}
						$sheet->setCellValue($currentCol.$currentRow, $detail);
					}
					$currentRow = $currentRow + 2; 
				}
				else{
					$currentRow = $currentRow + 1;
				}

				
			}
		})->setFilename($file_name)->store($this->file_extension,storage_path($file_path));
		$bill = new \App\Bill;
		$bill->filename = $file_name.'.'.$this->file_extension;
		$bill->filepath = $file_path.'/'.$file_name.'.'.$this->file_extension;
		$bill->code_id = $data_export[0]->order->code->id;
		$bill->save();
	}


	private function getCustomerData(){
		$customer_info = \App\Customer::find($this->id_customer)->toArray();
		$customer_data = collect([]);
		$customer_data->put('id',$customer_info['id']);
		$customer_data->put('name',$customer_info['first_name'].' '.$customer_info['last_name']);
		$customer_data->put('phone',$customer_info['phone_no']);
		$customer_data->put('address',$customer_info['address']);
		return $customer_data;
	}

	private function getExportData(){
		$export_info = \App\Export::with(['unit','order'])->where('code_id',$this->id_code)->get();
		return $export_info;
	}

	private function writeCustomer(&$sheet, $data_customer){
		$sheet->setCellValue('C5', '*'.$data_customer->get('id'));
		$sheet->setCellValue('C6', $data_customer->get('name'));
		$sheet->setCellValue('C7', $data_customer->get('address'));
		$sheet->setCellValue('C8', $data_customer->get('phone'));	
	}

	private function writeExportCode(&$sheet, $export_code){
		$sheet->setCellValue('U2', $export_code);
	}

	private function fileName(){

	}

	private function filePath(){

	}	

}