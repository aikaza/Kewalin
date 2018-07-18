<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
  <div class="tile-stats">
    <div class="icon">
      <i class="fa fa-level-down blue"></i>
    </div>
    <div class="count red" data-toggle="tooltip" title="{{number_format($data['import_count_for_this_month'])}}">
      {{ millionFormat($data['import_count_for_this_month'],100000) }}
    </div>
    <h3 style="color: #73879C">
      @lang('importing')
    </h3>
    <p>
      @lang('number of importing in this month')
    </p>
  </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
  <div class="tile-stats">
    <div class="icon">
      <i class="fa fa-level-up blue"></i>
    </div>
    <div class="count green" data-toggle="tooltip" title="{{ number_format($data['export_count_for_this_month'])}}">
      {{ number_format($data['export_count_for_this_month']) }}
    </div>
    <h3 style="color: #73879C">
     @lang('exporting')
   </h3>
   <p>
    @lang('number of exporting in this month')
  </p>
</div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
  <div class="tile-stats">
    <div class="icon">
      <i class="fa fa-btc blue"></i>
    </div>
    <div class="count red" data-toggle="tooltip" title="{{number_format($data['cost_count_for_this_month'])}}">
      {{ millionFormat($data['cost_count_for_this_month'],100000)}}
    </div>
    <h3 style="color: #73879C">
      @lang('expenses')
    </h3>
    <p>
      @lang('total expenses in this month')
    </p>
  </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
  <div class="tile-stats">
    <div class="icon">
      <i class="fa fa-btc blue"></i>
    </div>
    <div class="count green" data-toggle="tooltip" title="{{number_format($data['income_count_for_this_month'])}}">
      {{ millionFormat($data['income_count_for_this_month'],100000) }}
    </div>
    <h3 style="color: #73879C">
      @lang('incomes')
    </h3>
    <p>
      @lang('total incomes in this month')
    </p>
  </div>
</div>