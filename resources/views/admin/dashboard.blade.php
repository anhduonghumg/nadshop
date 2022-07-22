@extends('layouts.admin')
@section('title','dashboard')
@section('content')
<style>
    #btn-dashboard-filter,
    #btn-filter-month,
    #btn-filter-year {
        margin-top: 22px;
        margin-left: -16px;
    }
</style>
<div class="container-fluid py-5">
    <div class="row">
        <div class="col">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header text-center">ĐƠN HÀNG THÀNH CÔNG</div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $order_success }}</h5>
                    <p class="card-text">Đơn hàng giao dịch thành công</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header text-center">ĐANG XỬ LÝ</div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $order_pending }}</h5>
                    <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header text-center">DOANH SỐ</div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ currentcyFormat($sale) }}</h5>
                    <p class="card-text">Doanh số hệ thống</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header text-center">ĐƠN HÀNG HỦY</div>
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $order_cancel }}</h5>
                    <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end analytic  -->
    <div class="card">
        <div class="card-header font-weight-bold">
            THỐNG KÊ BÁN HÀNG THEO NGÀY
        </div>
        <div class="card-body">
            <form class='d-flex' autocomplete="off">
                <div class="col-md-3">
                    <span for="">Từ ngày</span>
                    <input type="text" name="datepicker" id='datepicker' class='form-control'>

                </div>
                <div class="col-md-3">
                    <span for="">Đến ngày</span>
                    <input type="text" name="datepicker2" id='datepicker2' class='form-control'>
                </div>
                <div class="col-md-3">
                    <button type="button" id="btn-dashboard-filter" class='btn btn-primary'>Lọc</button>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div id="chart" style=""></div>
        </div>
    </div>
    <div class="card">
        <div class="card-header font-weight-bold">
            THỐNG KÊ BÁN HÀNG THEO THÁNG
        </div>
        <div class="card-body card-month">
            <form class='d-flex' autocomplete="off">
                <div class="col-md-3">
                    <span for="">Từ tháng</span>
                    <input type="text" name="datepicker" id='first' class='form-control date-picker'>
                </div>
                <div class="col-md-3">
                    <span for="">Đến tháng</span>
                    <input type="text" name="datepicker2" id='last' class='form-control date-picker'>
                </div>
                <div class="col-md-3">
                    <button type="button" id="btn-filter-month" class='btn btn-primary'>Lọc</button>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div id="chart_month" style=""></div>
        </div>
    </div>
    <div class="card">
        <div class="card-header font-weight-bold">
            THỐNG KÊ BÁN HÀNG THEO NĂM
        </div>
        <div class="card-body card-month">
            <form class='d-flex' autocomplete="off">
                <div class="col-md-3">
                    <span for="">Từ năm</span>
                    <input type="text" name="datepicker" id='startYear' class='form-control date-picker-year'>
                </div>
                <div class="col-md-3">
                    <span for="">Đến năm</span>
                    <input type="text" name="datepicker2" id='lastYear' class='form-control date-picker-year'>
                </div>
                <div class="col-md-3">
                    <button type="button" id="btn-filter-year" class='btn btn-primary'>Lọc</button>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div id="chart_year" style=""></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $( function() {
        $("#datepicker").datepicker({
          dateFormat: "dd/mm/yy",
          dayNamesMin: ["T2","T3","T4","T5","T6","T7","CN"],
        });
        $("#datepicker2").datepicker({
            dateFormat: "dd/mm/yy",
            dayNamesMin: ["T2","T3","T4","T5","T6","T7","CN"],
          });
      });

      $(function() {
        function setDate(target, year, month, string) {
          var myDate;
          if ($(target).is("#first")) {
            day = 1;
            myDate = $.datepicker.parseDate("yy-mm-dd", year + "-" + month + "-01");
          } else {
            myDate = new Date(year, month, 0);
          }
          if (string) {
            $(target).val($.datepicker.formatDate("dd/mm/yy", myDate));
          } else {
            $(target).datepicker("setDate", myDate);
          }
        }

        $('.date-picker').datepicker({
          monthNamesShort: [ "Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4",
            "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9",
            "Tháng 10", "Tháng 11", "Tháng 12" ],
          changeMonth: true,
          changeYear: true,
          showButtonPanel: true,
          dateFormat: 'dd/mm/yy',
          onChangeMonthYear: function(yy, mm) {
            setDate(this, yy, mm, true);
          },
          onClose: function(dateText, inst) {
            if ($(this).is("#first")) {
              setDate("#last", inst.selectedYear, inst.selectedMonth + 1, true);
            }
          }
        }).focus(function () {
            $(".ui-datepicker-calendar").hide();
            $(".ui-datepicker-prev").hide();
            $(".ui-datepicker-next").hide();
            $("#ui-datepicker-div").position({
              my: "left top",
              at: "left bottom",
              of: $(this)
            });
          }).attr("readonly", false);
      });

      $(function() {
        $('.date-picker-year').datepicker( {
          yearRange: "c-100:c",
          changeMonth: false,
          changeYear: true,
          showButtonPanel: true,
          closeText:'Select',
          currentText: 'This year',
          onClose: function(dateText, inst) {
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val($.datepicker.formatDate('yy', new Date(year, 1, 1)));
          }
        }).focus(function () {
          $(".ui-datepicker-month").hide();
          $(".ui-datepicker-calendar").hide();
          $(".ui-datepicker-current").hide();
          $(".ui-datepicker-prev").hide();
          $(".ui-datepicker-next").hide();
          $("#ui-datepicker-div").position({
            my: "left top",
            at: "left bottom",
            of: $(this)
          });
        }).attr("readonly", false);
      });
</script>

<script type="text/javascript">
    load_chart();
    var chart = new Morris.Area({
        element: 'chart',
        lineColors: ['#819C79','#fc8710','#FF6541','#A4ADD3','#766B56'],
        parseTime: false,
        hideHover: 'auto',
        gridTextSize: 12,
        xkey: 'period',
        ykeys: ['sale','profit'],
        labels: ['Doanh số','Lợi nhuận'],
      });

      var chart_month = new Morris.Area({
        element: 'chart_month',
        lineColors: ['#819C79','#fc8710','#FF6541','#A4ADD3','#766B56'],
        parseTime: false,
        hideHover: 'auto',
        gridTextSize: 12,
        xkey: 'period',
        ykeys: ['sale','profit'],
        labels: ['Doanh số','Lợi nhuận'],
      });

      var chart_year = new Morris.Area({
        element: 'chart_year',
        lineColors: ['#819C79','#fc8710','#FF6541','#A4ADD3','#766B56'],
        parseTime: false,
        hideHover: 'auto',
        gridTextSize: 12,
        xkey: 'period',
        ykeys: ['sale','profit'],
        labels: ['Doanh số','Lợi nhuận'],
      });


    $(document).on('click','#btn-dashboard-filter',function(){
        var from_date = $('#datepicker').val() ? $('#datepicker').val() : '';
        var to_date = $('#datepicker2').val() ? $('#datepicker2').val() : '';
        $(".loadajax").show();
        $.ajax({
            url: "{{ route('dashboard.filter.date') }}",
            type: "POST",
            data: { from_date:from_date,to_date:to_date },
            dataType: "json",
            success: function (rsp) {
                $(".loadajax").hide();
                if($.isEmptyObject(rsp.errors)){
                    chart.setData(rsp);
                }else{
                    confirm_warning(rsp.errors);
                }
            },error: function () {
            $(".loadajax").hide();
           alert("error!!!!");
            },
        });
    })

    $(document).on('click','#btn-filter-month',function(){
        var from_month = $('#first').val() ? $('#first').val() : '';
        var to_month = $('#last').val() ? $('#last').val() : '';
        $(".loadajax").show();
        $.ajax({
            url: "{{ route('load.chartMonth') }}",
            type: "POST",
            data: { from_month:from_month,to_month:to_month },
            dataType: "json",
            success: function (rsp) {
                $(".loadajax").hide();
                if($.isEmptyObject(rsp.errors)){
                    chart_month.setData(rsp);
                }else{
                    confirm_warning(rsp.errors);
                }
            },error: function () {
            $(".loadajax").hide();
           alert("error!!!!");
            },
        });
    })

    $(document).on('click','#btn-filter-year',function(){
        var fromYear = $('#startYear').val() ? $('#startYear').val() : '';
        var toYear = $('#lastYear').val() ? $('#lastYear').val() : '';
        $(".loadajax").show();
        $.ajax({
            url: "{{ route('load.chartYear') }}",
            type: "POST",
            data: { fromYear:fromYear,toYear:toYear},
            dataType: "json",
            success: function (rsp) {
                $(".loadajax").hide();
                if($.isEmptyObject(rsp.errors)){
                    chart_year.setData(rsp);
                }else{
                    confirm_warning(rsp.errors);
                }
            },error: function () {
            $(".loadajax").hide();
           alert("error!!!!");
            },
        });
    })

    function load_chart(){
        $.ajax({
            url: "{{ route('load.chart') }}",
            type: "POST",
            dataType: "json",
            success: function (rsp) {
              chart.setData(rsp);
            },error: function () {
           alert("error!!!!");
            },
        });
    }
</script>
@endsection
