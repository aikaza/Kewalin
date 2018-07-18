@extends('layouts.app')
@section('php')
@php
$pd = \App\Product::find($product_id);
@endphp
@endsection
@section('content')
<!-- page content -->
<div class="right_col" role="main" style="background-color: white !important">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_title">
                    <h2>
                        <ul class="breadcrumb" style="padding: 0;background-color: transparent;margin: 0">
                            <li>
                                <a href="{{ route('stocks.index') }}">
                                    @lang('stock')
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('stocks.detail',$pd->id) }}">
                                    @lang('detail')
                                    <code>
                                        #{{ $pd->code }} {{ $pd->name }}
                                    </code>
                                </a>
                            </li>
                            <li class="active">
                                @lang('all exporting list')
                            </li>
                        </ul>
                    </h2>
                    <div class="clearfix">
                    </div>
                </div>
                <div class="x_content">
                    <table class="table table-striped table-bordered jambo_table custom-table full-width hoveron" id="s-table">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    @lang('color')
                                </th>
                                <th>
                                    @lang('qty :param',['param' => __('roll')])
                                </th>
                                <th>
                                    @lang('qty :param',['param' => __('2ry')])
                                </th>
                                <th>
                                    @lang('export price')
                                </th>
                                <th>
                                    @lang('lot number')
                                </th>
                                <th>
                                    @lang('date')
                                </th>
                                <th>
                                    @lang('issue by')
                                </th>
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
    $(document).ready(() => {

		product_id = <?php echo $product_id; ?>;

		url = apiURL('dt:export:list',product_id),
		datatable = $('#s-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: url,
			columns: [
			{ data : 'DT_Row_Index', name : 'DT_Row_Index'},
			{ data : 'p_color', name : 'p_color'},
			{ data : 'qtyp', name : 'qtyp'},
			{ data : 'qtys', name : 'qtys'},
			{ data : 'price_per_unit', name : 'price_per_unit'},
			{ data : 'lot_number', name : 'lot_number'},
			{ data : 'created_at', name : 'created_at' },
			{ data : 'created_by', name : 'created_by' }
			]
		});
	});
</script>
@endsection
