@extends('layouts.app')
@section('php')
@php
$status_data = [
  'new_orders' => $new_orders,
  'new_orders_this_week' => $new_orders_this_week,
  'cri_products' => $cri_products,
  'outdate_products' => $outdate_products,
  'remain_products' => $remain_products,
  'remain_products_this_week' => $remain_products_this_week,
  'total_products' => $total_products,
  'total_products_this_week' => $total_products_this_week,
  'total_customers' => $total_customers,
  'total_customers_this_week' => $total_customers_this_week
];
$statistic_data = [
  'import_count_for_this_month' => $import_count_for_this_month,
  'export_count_for_this_month' => $export_count_for_this_month,
  'cost_count_for_this_month' => $cost_count_for_this_month,
  'income_count_for_this_month' => $income_count_for_this_month
];
@endphp
@endsection
@include('class.seven-most-class')
@section('content')
<div class="right_col" role="main">
  <div class="row">
    @include('index.topbar-status',['data' => $status_data])
  </div>

  <div class="row">
    @include('index.seven-most-importing',['data' => $seven_most_importing])
    @include('index.seven-most-exporting',['data' => $seven_most_exporting])
    @include('index.seven-most-customer-support',['data' => $seven_most_customers_support])
  </div>
  <div class="row">
    @include('index.bottombar-statistic',['data' => $statistic_data])
  </div>
</div>
@endsection


