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
            รายงานสรุปยอดซื้อภายในวันที่ {{ $date_start }} ถึง {{ $date_end }}
        </h2>
        <h3>
            รวมยอดซื้อทั้งหมด {{ number_format($total,2) }} บาท
        </h3>
        <table class="table table-striped table-bordered">
            <thead style="display: table-header-group;">
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        วันที่
                    </th>
                    <th>
                        รหัสสินค้า
                    </th>
                    <th>
                        สี
                    </th>
                    <th>
                        จำนวนม้วน
                    </th>
                    <th>
                        จำนวนหน่วยรอง
                    </th>
                    <th>
                        ราคาทุน/หน่วย
                    </th>
                    <th>
                        จำนวนเงิน
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
                        {{ explode(' ', $d->created_at)[0] }}
                    </td>
                    <td>
                        {{ $d->product->code }}
                    </td>
                    <td>
                        {{ $d->product_color }}
                    </td>
                    <td>
                        {{ number_format($d->qtyp, 2) }}
                    </td>
                    <td>
                        {{ number_format($d->qtys, 2) }} {{ strtoupper($d->unit->prefix) }}
                    </td>
                    <td>
                       &#3647; {{ number_format($d->cost_per_unit, 2) }}
                    </td>
                    <td>
                        &#3647; {{ number_format($d->total_cost, 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>