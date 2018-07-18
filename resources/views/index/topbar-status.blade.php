<div class="row tile_count">
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top">
            <i class="fa fa-exchange">
            </i>
            @lang('new order qty')
        </span>
        <div class="count">
            <a class="green" href="{{ route('orders.new.orders') }}">
                {{ $data['new_orders'] }}
            </a>
        </div>
        <span class="count_bottom">
            <i class="green">
                +{{ $data['new_orders_this_week'] }}
            </i>
            <i>
                @lang('within this week')
            </i>
        </span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top">
            <i class="fa fa-cube">
            </i>
            @lang('critical product')
        </span>
        <div class="count">
            <a class="red" href="{{ route('stocks.cri.products') }}">
                {{ $data['cri_products'] }}
            </a>
        </div>
        <span class="count_bottom">
            <i>
                @lang('no presentation')
            </i>
        </span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top">
            <i class="fa fa-cube">
            </i>
            @lang('outstanding product')
        </span>
        <div class="count">
            <a class="red" href="{{ route('stocks.outdate.products') }}">
                {{ $data['outdate_products'] }}
            </a>
        </div>
        <span class="count_bottom">
            <i>
                @lang('no presentation')
            </i>
        </span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top">
            <i class="fa fa-cube">
            </i>
            @lang('remaining product')
        </span>
        <div class="count">
            <a class="blue" href="{{ route('stocks.remain.products') }}">
                {{ $data['remain_products'] }}
            </a>
        </div>
        <span class="count_bottom">
            <i class="green">
                +{{ $data['remain_products_this_week'] }}
            </i>
            <i>
                @lang('within this week')
            </i>
        </span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top">
            <i class="fa fa-cube">
            </i>
            @lang('qty product')
        </span>
        <div class="count">
            <a class="blue" href="{{ route('stocks.index') }}">
                {{ $data['total_products'] }}
            </a>
        </div>
        <span class="count_bottom">
            <i class="green">
                +{{ $data['total_products_this_week'] }}
            </i>
            <i>
                @lang('within this week')
            </i>
        </span>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top">
            <i class="fa fa-user">
            </i>
            @lang('qty customer')
        </span>
        <div class="count">
            <a class="blue" href="{{ route('customers.index') }}">
                {{ $data['total_customers'] }}
            </a>
        </div>
        <span class="count_bottom">
            <i class="green">
                +{{ $data['total_customers_this_week'] }}
            </i>
            <i>
                @lang('within this week')
            </i>
        </span>
    </div>
</div>