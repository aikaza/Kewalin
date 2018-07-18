@extends('layouts.app')

@section('content')
<div class="right_col" role="main" style="background-color: white !important">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_title">
                    <h2>
                        <ul class="breadcrumb" style="padding: 0;background-color: transparent;margin: 0">
                            <li>
                                <a href="{{ route('reports.index','buy') }}">
                                    @lang('report')@lang('buy')
                                </a>
                            </li>
                            <li class="active">
                                @lang('new record')
                            </li>
                        </ul>
                    </h2>
                    <div class="clearfix">
                    </div>
                </div>
                <div class="x_content" style="padding: 0 38%">
                    <div id="first-scene">
                        <div>
                            <label>
                                @lang('type')
                            </label>
                            <input checked="" id="type-all" name="type" type="radio" value="all">
                                <label for="type-all">
                                    @lang('all')
                                </label>
                                <input id="type-indiv" name="type" type="radio" value="by_product">
                                    <label for="type-indiv">
                                        รหัสสินค้า
                                    </label>
                                </input>
                            </input>
                        </div>
                        <div id="product-div" style="margin-bottom: 16px;display: none;">
                            <input class="form-control" id="product-input" placeholder="รหัสสินค้า" type="text">
                            </input>
                        </div>
                        <div class="form-control" id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar">
                            </i>
                            <span>
                            </span>
                            <i class="fa fa-caret-down">
                            </i>
                        </div>
                        <div style="margin-top: 16px;">
                            <button class="btn btn-success btn-block" id="submit-btn">
                                Submit
                            </button>
                        </div>
                    </div>
                    <div id="second-scene" style="display: none">
                        <p class="text-success">
                            สร้างไฟล์เรียบร้อย
                            <span id="file_name">
                            </span>
                        </p>
                        <a class="btn btn-primary" id="download-btn">
                            ดาวโหลดไฟล์
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group">
                    <label for="comment">
                        Note:
                    </label>
                    <textarea class="form-control" id="note-text" rows="5" style="margin-bottom: 8px">
                    </textarea>
                    <button class="btn btn-success" id="confirm-submit-btn">
                        Submit
                    </button>
                    <button class="btn btn-danger" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('sc')
<script type="text/javascript">
    var startDate = moment().startOf('month').format('YYYY-MM-DD');
    var endDate  = moment().endOf('month').format('YYYY-MM-DD');
    var type = 'all';
    var productId = null;




    $(function() {

    var start = moment().startOf('month');
    var end = moment().endOf('month');

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    $('#reportrange').on('apply.daterangepicker',function(ev, picker){
      startDate = picker.startDate.format('YYYY-MM-DD');
      endDate = picker.endDate.format('YYYY-MM-DD');
    });
});
    $(document).ready(function(){

        let data = new Data();

        initSuggestion('product',function(res){
            data.keep('p_suggestions',res.suggestions);
        });

        $('#product-input').autocomplete({
            lookup : data.get('p_suggestions'),
            lookupLimit : 20,
            autoSelectFirst : true,
            onSelect : function(suggestion){
                customerId = suggestion.data;
            }
        });

        $('input[type=radio][name=type]').change(function(){
            let val = $(this).val();
            type = val;
            if(val === 'all'){
                $('#product-div').hide();
            }else{
                $('#product-div').show();
            }
        });

        $('#submit-btn').click(function(){
            let type_val = $('input[type=radio][name=type]:checked').val();
            if(type_val === 'all'){
                $('#note-text').val('รายงานสรุปยอดซื้อระหว่างวันที่ '+ startDate + ' ถึง '+ endDate + '   (ทั้งหมด)');
            }else{
                $('#note-text').val('รายงานสรุปยอดซื้อระหว่างวันที่ '+ startDate + ' ถึง '+ endDate + '   ('+ $('#product-input').val() +')');
            }
            $('#modal').modal('show');
        });

        $('#confirm-submit-btn').click(function(){
            $('#modal').modal('hide');
            let note = $('#note-text').val();
            $.ajax({
                url: '/reports/generate/buy',
                type: 'POST',
                dataType: 'json',
                data: {
                    date_start : startDate,
                    date_end : endDate,
                    note : note,
                    product_id : productId,
                    mode : type
                }
            }).fail((xhr, status, error) => {
                console.log(status);
            }).done( result => {
                if(result.length === 0){
                    alert('ไม่มีรายการในช่วงเวลาที่กำหนด');
                }
                else{
                    $('#first-scene').remove();
                    $('#second-scene').show();
                    $('#download-btn').attr('href', apiURL('report:download', result.file_name));
                    $('#file_name').text(result.file_name);
                }
            });
        });
    });
</script>
@endsection
