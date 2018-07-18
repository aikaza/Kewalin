<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Datatables\DebtListDtTrait;
use App\Traits\Datatables\BillListDtTrait;
use App\Traits\Datatables\StockIndexDtTrait;
use App\Traits\Datatables\OrderIndexDtTrait;
use App\Traits\Datatables\ExportListDtTrait;
use App\Traits\Datatables\ImportListDtTrait;
use App\Traits\Datatables\ReportIndexDtTrait;
use App\Traits\Datatables\ReturnIndexDtTrait;
use App\Traits\Datatables\ExportIndexDtTrait;
use App\Traits\Datatables\InvoiceIndexDtTrait;
use App\Traits\Datatables\ProductIndexDtTrait;
use App\Traits\Datatables\BillPaidListDtTrait;
use App\Traits\Datatables\CustomerIndexDtTrait;
use App\Traits\Datatables\ExportBillListDtTrait;

class DatatableController extends Controller
{
    use 
    DebtListDtTrait,
    BillListDtTrait,
    StockIndexDtTrait,
    OrderIndexDtTrait,
    ExportListDtTrait,
    ImportListDtTrait,
    ReportIndexDtTrait,
    ReturnIndexDtTrait,
    ExportIndexDtTrait,
    InvoiceIndexDtTrait,
    BillPaidListDtTrait,
    ProductIndexDtTrait,
    CustomerIndexDtTrait,
    ExportBillListDtTrait;
}
