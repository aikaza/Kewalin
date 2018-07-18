<?php 

namespace App\Classes;
use Excel;
use PHPExcel_Worksheet_PageSetup;
use App\Classes\BillMaker;
use App\Classes\CodeGenerator;

class DebtBillMaker extends BillMaker{

	private $export_ref;
	private $code_id;

	public function setExportRefList(array $export_ref){
		$this->export_ref = $export_ref;
	}

	protected function getBillNumber(){
		$cg = new CodeGenerator(appconfig('iv_prefix'), appconfig('iv_length'));
		$result = $cg->make();
		$this->code_id = $cg->getId();
		return $result->code;
	}

	protected function generateFileName($code){
		return 'debt_'.$code;
	}

	protected function generateFilePath(){
		return 'bill/'.date('Y-m-d').'/debt';
	}

	protected function makeDataArray(){
		return [
			'customer' => $this->getCustomer(),
			'date' => $this->getDate(),
			'bill_number' => $this->getBillNumber(),
			'invoice_list' => $this->getInvoiceList()
		];
	}

	protected function storeData(){

	}

	private function getInvoiceList(){
		$export_codes = implode(',', array_map(function($v){
			return "'".$v."'";
		}, $this->export_ref));
		$invoice_list = \DB::select("
			SELECT 	cd.code code, MAX(date(e.created_at)) date,
			SUM(o.qtyp) qtyp, SUM(e.qtys) qtys, MAX(e.price_per_unit) price,
			CONCAT('*', GROUP_CONCAT(DISTINCT p.code)) product,
			GROUP_CONCAT(DISTINCT u.prefix) unit
			FROM exports e
			INNER JOIN orders o ON o.id = e.order_id
			INNER JOIN customers c ON c.id = o.customer_id
			INNER JOIN products p ON p.id = o.product_id
			INNER JOIN units u ON u.id = e.unit_id
			INNER JOIN codes cd ON cd.id = e.code_id 
			GROUP BY code
			HAVING code IN ($export_codes)
			");
		return $invoice_list;
	}

	public function make(){
		$data = $this->makeDataArray();
		$file_name = $this->generateFileName($data['bill_number']);
		$file_path = $this->generateFilePath();
		Excel::load(storage_path('bill/วางบิล 9x7.xlsx'), function($reader) use ($data){ 
			$sheet = $reader->getSheetByName('วางบิล');
			$sheet->setCellValue('C4', '*'.$data['customer']->id);
			$sheet->setCellValue('C5', $data['customer']->first_name.' '.$data['customer']->last_name);
			$sheet->setCellValue('C6', $data['customer']->address);
			$sheet->setCellValue('C7', $data['customer']->phone_no);
			$sheet->setCellValue('K2', $data['bill_number']);
			$sheet->setCellValue('K3', $data['date']);
			$col_index = 'A';
			$col_export_code = 'B';
			$col_export_date = 'D';
			$col_product = 'E';
			$col_qtyp = 'H';
			$col_qtys = 'I';
			$col_unit = 'J';
			$col_price = 'K';
			$col_total_price = 'L';
			$curr_row = 11;
			$total_price = 0;
			foreach ($data['invoice_list'] as $i => $d) {
				$sheet->setCellValue($col_index.$curr_row, $i+1);
				$sheet->setCellValue($col_export_code.$curr_row, $d->code);
				$sheet->setCellValue($col_export_date.$curr_row, $d->date);
				$sheet->setCellValue($col_product.$curr_row, $d->product);
				$sheet->setCellValue($col_qtyp.$curr_row, $d->qtyp);
				$sheet->setCellValue($col_qtys.$curr_row, $d->qtys);
				$sheet->setCellValue($col_unit.$curr_row, strtoupper($d->unit));
				$sheet->setCellValue($col_price.$curr_row, $d->price);
				$sheet->setCellValue($col_total_price.$curr_row, $d->qtys*$d->price);
				$total_price += $d->qtys*$d->price;
				$curr_row++; 
			}
			$sheet->setCellValue('L20', $total_price);
			$sheet->setCellValue('C20', $this->getTextBaht($total_price, 2));
			$pageSetup = new PHPExcel_Worksheet_PageSetup;
			$pageSetup->setScale(50);
			$sheet->setPageSetup($pageSetup);

		})->setFilename($file_name)->store('xlsx',storage_path($file_path));

		$bill = new \App\Bill;
		$bill->filename = $file_name.'.xlsx';
		$bill->filepath = $file_path.'/'.$file_name.'.xlsx';
		$bill->code_id = $this->code_id;
		$bill->save();

		$this->updateBillStatus($data);

		
	}

	private function updateBillStatus($data){
		$total_debt = 0;
		foreach ($this->export_ref as $code) {
			$ex = \App\Export::whereHas('code', function($query) use($code){
				$query->where('code',$code);
			})->get();
			$ex->each(function($e) use(&$total_debt){
				$e->makebill = 'yes';
				$e->save();
				$total_debt += $e->total_price;
			});
		}
		$debt = new \App\DebtBill;
		$debt->customer_id = $data['customer']->id;
		$debt->code_id = $this->code_id;
		$debt->total_debt = $total_debt;
		$debt->save();


	}


}