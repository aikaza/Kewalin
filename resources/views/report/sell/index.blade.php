@extends('layouts.app')

@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_title">
                    <h2>@lang('report')@lang('sell')</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button class="btn btn-success input-sm" onclick="location.href = '{{ route('reports.create','sell') }}'">
                                <i class="fa fa-paper-plane"></i> 
                                @lang('new record')
                            </button>
                        </li>
                        <li>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="table" class="table table-striped table-bordered jambo_table full-width hoveron">
                        <thead>
                            <tr>
                                <th style="width: 15%" rowspan="2">
                                    #
                                </th>
                                <th colspan="4">@lang('detail')</th>
                            </tr>
                            <tr>
                                <th>@lang('date start')</th>
                                <th>@lang('date end')</th>
                                <th>@lang('note')</th>
                                <th>@lang('download file')</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection

@section('sc')
<script type="text/javascript">

    $(document).ready(function(){

        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: apiURL('dt:report','sell'),
            columns: [
            { data: 'DT_Row_Index', name: 'DT_Row_Index', class: 'text-center' },
            { data: 'date_start', name: 'date_start' },
            { data: 'date_end', name: 'date_end' },
            { data: 'note', name: 'note', orderable : false },
            { data: 'path', name: 'path', orderable : false}
            ]
        });
    });

</script>
@endsection