<?php

namespace App\Traits\Datatables;

use DataTables;

trait ReportIndexDtTrait
{

    public function ReportIndexDt($type)
    {
        $data = \DB::select("
        	SELECT 	DATE_FORMAT(date_start, '%d %b %Y') date_start,
					DATE_FORMAT(date_end, '%d %b %Y') date_end,
					path, note
			FROM 	reports
            WHERE type = ?
			ORDER BY created_at DESC
		",[$type]);
        return DataTables::of($data)
        	->addIndexColumn()
            ->editColumn('path', function($data){
                return '<a class="text-primary" href="'.route('reports.download',$data->path).'">ดาวน์โหลดไฟล์</a>';
            })
            ->rawColumns(['path'])
            ->toJson();
    }
}
