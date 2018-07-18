<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
        <link href="{{ public_path('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
            
                <style type="text/css">
                @font-face {
                    font-family: 'THSarabunNew';
                    font-style: normal;
                    font-weight: normal;
                    src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
                }
                @font-face {
                    font-family: 'THSarabunNew';
                    font-style: normal;
                    font-weight: bold;
                    src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
                }
                @font-face {
                    font-family: 'THSarabunNew';
                    font-style: italic;
                    font-weight: normal;
                    src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
                }
                @font-face {
                    font-family: 'THSarabunNew';
                    font-style: italic;
                    font-weight: bold;
                    src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
                }
                @font-face {
                    font-family: 'Kanit';
                    font-style: normal;
                    font-weight: normal;
                    src: url("{{ public_path('fonts/Kanit/Kanit-Regular.ttf') }}") format('truetype');
                }
                @font-face {
                    font-family: 'Kanit';
                    font-style: normal;
                    font-weight: bold;
                    src: url("{{ public_path('fonts/Kanit/Kanit-Bold.ttf') }}") format('truetype');
                }
                @font-face {
                    font-family: 'Kanit';
                    font-style: italic;
                    font-weight: normal;
                    src: url("{{ public_path('fonts/Kanit/Kanit-Italic.ttf') }}") format('truetype');
                }
                @font-face {
                    font-family: 'Kanit';
                    font-style: italic;
                    font-weight: bold;
                    src: url("{{ public_path('fonts/Kanit/Kanit-BoldItalic.ttf') }}") format('truetype');
                }  
        body{
            font-family: 'Kanit' !important;
        }
    </style>
    </head>
    <body>
        <h2>
            รายงานสรุปยอดขายภายในวันที่ {{ $date_start }} ถึง {{ $date_end }}
        </h2>
        <h3>
            รวมยอดทั้งหมด {{ number_format($total,2) }} บาท
        </h3>
        <table class="table table-striped table-bordered">
            <thead style="display: table-header-group;">
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        เลขที่บิล
                    </th>
                    <th>
                        วันที่
                    </th>
                    <th>
                        รหัสลูกค้า
                    </th>
                    <th>
                        ชื่อลูกค้า
                    </th>
                    <th>
                        จำนวนเงิน
                    </th>
                    <th>
                        สถานะ
                    </th>
                    <th>
                        วันที่โอน
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i => $d)
                <tr style="page-break-inside: avoid;">
                    <td>
                        {{ $i + 1 }}
                    </td>
                    <td>
                        {{ $d->code->code }}
                    </td>
                    <td>
                        {{ explode(' ', $d->created_at)[0] }}
                    </td>
                    <td>
                        {{ $d->customer->id }}
                    </td>
                    <td>
                        {{ $d->customer->first_name }} {{ $d->customer->last_name }}
                    </td>
                    <td>
                        {{ number_format($d->total_debt, 2) }}
                    </td>
                    <td>
                        @if ($d->status === 'pending')
                            ค้างจ่าย
                        @else
                            จ่ายแล้ว
                        @endif
                    </td>
                    <td>
                        {{ (is_null($d->issue_date)) ? "-" : $d->issue_date }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>