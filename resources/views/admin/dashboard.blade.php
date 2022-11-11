@extends('layouts.admin')
@section('title', 'dashboard')
@section('content')
    <style>
        #btn-dashboard-filter,
        #btn-filter-month,
        #btn-filter-year {
            margin-top: 22px;
            margin-left: -16px;
        }

        #btn-export-excel-date,
        #btn-export-excel-month,
        #btn-export-excel-year {
            margin-top: 22px;
            margin-left: 15px;
        }

        .product_best_sell {
            list-style: none;
            padding: 0px;
            background-color: #ffffff;
            width: 550px;
        }

        .product_best_sell li {
            display: flex;
            margin-left: 12px;
            padding-top: 10px;
            padding-bottom: 7px;
            border-bottom: 1px solid #eee;
        }

        .product_best_sell li .info {
            margin-left: 20px;
        }

        .product_best_sell p.price {
            margin-top: 5px;
        }

        ul#myTab li button {
            padding: 12px 57px;
        }

        ul#myTopView li button {
            padding: 12px 57px;
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
                        <button type="button" id="btn-export-excel-date" class='btn btn-success'>Xuất excel</button>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div id="chart"></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header font-weight-bold">
                THỐNG KÊ BÁN HÀNG THEO THÁNG CÙNG NĂM
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
                        <button type="button" id="btn-export-excel-month" class='btn btn-success'>Xuất excel</button>
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
                        <button type="button" id="btn-export-excel-year" class='btn btn-success'>Xuất excel</button>
                    </div>
                </form>
            </div>
            <div class="col-md-12">
                <div id="chart_year" style=""></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header font-weight-bold">
                TOP 10 SẢN PHẨM
            </div>
            <div class="row">
                <div class="col-6">
                    <p class="text-center">BÁN CHẠY</p>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active best_sell" id="day-tab" data-toggle="tab"
                                data-target="#day" type="button" role="tab" aria-controls="day"
                                aria-selected="true" value="day">Ngày</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link best_sell" id="week-tab" data-toggle="tab" data-target="#week"
                                type="button" role="tab" aria-controls="week" aria-selected="false"
                                value="week">Tuần</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link best_sell" id="month-tab" data-toggle="tab" data-target="#month"
                                type="button" role="tab" aria-controls="contact" aria-selected="false"
                                value="month">Tháng</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myBestSell">
                        <div class="tab-pane fade show active" id="day" role="tabpanel" aria-labelledby="day-tab">

                        </div>
                        <div class="tab-pane fade" id="week" role="tabpanel" aria-labelledby="week-tab">
                        </div>
                        <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <p class="text-center">XEM NHIỀU NHẤT</p>
                    <ul class="nav nav-tabs" id="myTopView" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active top_view" id="dayview-tab" data-toggle="tab"
                                data-target="#dayview" type="button" role="tab" aria-controls="home"
                                aria-selected="true" value="dayview">Ngày</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link top_view" id="week-tab" data-toggle="tab" data-target="#weekview"
                                type="button" role="tab" aria-controls="profile" aria-selected="false"
                                value="weekview">Tuần</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link top_view" id="month-tab" data-toggle="tab" data-target="#monthview"
                                type="button" role="tab" aria-controls="contact" aria-selected="false"
                                value="monthview">Tháng</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabViewContent">
                        <div class="tab-pane show active" id="dayview" role="tabpanel" aria-labelledby="home-tab">
                        </div>
                        <div class="tab-pane fade" id="weekview" role="tabpanel" aria-labelledby="profile-tab">
                        </div>
                        <div class="tab-pane fade" id="monthview" role="tabpanel" aria-labelledby="contact-tab">
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-12">
                <div id="chart_year" style=""></div>
            </div> --}}
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $("#datepicker").datepicker({
                dateFormat: "dd/mm/yy",
                dayNamesMin: ["T2", "T3", "T4", "T5", "T6", "T7", "CN"],
            });
            $("#datepicker2").datepicker({
                dateFormat: "dd/mm/yy",
                dayNamesMin: ["T2", "T3", "T4", "T5", "T6", "T7", "CN"],
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
                monthNamesShort: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4",
                    "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9",
                    "Tháng 10", "Tháng 11", "Tháng 12"
                ],
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
            }).focus(function() {
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
            $('.date-picker-year').datepicker({
                yearRange: "c-100:c",
                changeMonth: false,
                changeYear: true,
                showButtonPanel: true,
                closeText: 'Select',
                currentText: 'This year',
                onClose: function(dateText, inst) {
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).val($.datepicker.formatDate('yy', new Date(year, 1, 1)));
                }
            }).focus(function() {
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
        var chart = new Morris.Area({
            element: 'chart',
            lineColors: ['#819C79', '#fc8710', '#FF6541'],
            parseTime: false,
            hideHover: 'auto',
            gridTextSize: 12,
            xkey: 'period',
            ykeys: ['sale', 'profit', 'product_qty'],
            labels: ['Doanh số', 'Lợi nhuận', 'Số Sản phẩm'],
            // ykeys: ['product_qty'],
            // labels: ['Số Sản phẩm'],
        });

        var chart_month = new Morris.Area({
            element: 'chart_month',
            lineColors: ['#819C79', '#fc8710', '#FF6541', '#A4ADD3', '#766B56'],
            parseTime: false,
            hideHover: 'auto',
            gridTextSize: 12,
            xkey: 'period',
            ykeys: ['sale', 'profit', 'product_qty'],
            labels: ['Doanh số', 'Lợi nhuận', 'Số sản phẩm'],
        });

        var chart_year = new Morris.Area({
            element: 'chart_year',
            lineColors: ['#819C79', '#fc8710', '#FF6541', '#A4ADD3', '#766B56'],
            parseTime: false,
            hideHover: 'auto',
            gridTextSize: 12,
            xkey: 'period',
            ykeys: ['sale', 'profit', 'product_qty'],
            labels: ['Doanh số', 'Lợi nhuận', 'Số sản phẩm'],
        });

        load_chart();

        $(document).on('click', '#btn-export-excel-date', function() {
            let from_date = $('#datepicker').val() ? $('#datepicker').val() : '';
            let to_date = $('#datepicker2').val() ? $('#datepicker2').val() : '';
            $(".loadajax").show();
            $.ajax({
                url: "{{ route('dashboard.export.excel.date') }}",
                type: "post",
                data: {
                    from_date: from_date,
                    to_date: to_date
                },
                xhrFields: {
                    responseType: 'blob',
                },
                success: function(rsp, status, xhr) {
                    $(".loadajax").hide();

                    var disposition = xhr.getResponseHeader('content-disposition');
                    var matches = /"([^"]*)"/.exec(disposition);
                    var filename = (matches != null && matches[1] ? matches[1] :
                        'baocaodoanhthungay.xlsx');
                    // The actual download
                    var blob = new Blob([rsp], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $(".loadajax").hide();
                    confirm_warning(
                        "Không được để trống dữ liệu và ngày bắt đầu không được lớn hơn ngày kết thúc"
                    );
                },
            });
        });

        $(document).on('click', '#btn-export-excel-month', function() {
            var from_month = $('#first').val() ? $('#first').val() : '';
            var to_month = $('#last').val() ? $('#last').val() : '';
            $(".loadajax").show();
            $.ajax({
                url: "{{ route('dashboard.export.excel.month') }}",
                type: "post",
                data: {
                    from_month: from_month,
                    to_month: to_month
                },
                xhrFields: {
                    responseType: 'blob',
                },
                success: function(rsp, status, xhr) {
                    $(".loadajax").hide();
                    var disposition = xhr.getResponseHeader('content-disposition');
                    var matches = /"([^"]*)"/.exec(disposition);
                    var filename = (matches != null && matches[1] ? matches[1] :
                        'baocaodoanhthuthang.xlsx');
                    // The actual download
                    var blob = new Blob([rsp], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $(".loadajax").hide();
                    confirm_warning(
                        "Không được để trống dữ liệu và tháng bắt đầu không được lớn hơn tháng kết thúc"
                    );
                },
            });
        });

        $(document).on('click', '#btn-export-excel-year', function() {
            let fromYear = $('#startYear').val() ? $('#startYear').val() : '';
            let toYear = $('#lastYear').val() ? $('#lastYear').val() : '';
            $(".loadajax").show();
            $.ajax({
                url: "{{ route('dashboard.export.excel.year') }}",
                type: "post",
                data: {
                    fromYear: fromYear,
                    toYear: toYear
                },
                xhrFields: {
                    responseType: 'blob',
                },
                success: function(rsp, status, xhr) {
                    $(".loadajax").hide();
                    var disposition = xhr.getResponseHeader('content-disposition');
                    var matches = /"([^"]*)"/.exec(disposition);
                    var filename = (matches != null && matches[1] ? matches[1] :
                        'baocaodoanhthunam.xlsx');
                    // The actual download
                    var blob = new Blob([rsp], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $(".loadajax").hide();
                    confirm_warning(
                        "Không được để trống dữ liệu và năm bắt đầu không được lớn hơn năm kết thúc"
                    );
                },
            });
        });

        $(document).on('click', '#btn-dashboard-filter', function() {
            var from_date = $('#datepicker').val() ? $('#datepicker').val() : '';
            var to_date = $('#datepicker2').val() ? $('#datepicker2').val() : '';
            $(".loadajax").show();
            $.ajax({
                url: "{{ route('dashboard.filter.date') }}",
                type: "POST",
                data: {
                    from_date: from_date,
                    to_date: to_date
                },
                dataType: "json",
                success: function(rsp) {
                    $(".loadajax").hide();
                    if ($.isEmptyObject(rsp.errors)) {
                        chart.setData(rsp);
                    } else {
                        confirm_warning(rsp.errors);
                    }
                },
                error: function() {
                    $(".loadajax").hide();
                    alert("error!!!!");
                },
            });
        })

        $(document).on('click', '#btn-filter-month', function() {
            var from_month = $('#first').val() ? $('#first').val() : '';
            var to_month = $('#last').val() ? $('#last').val() : '';
            $(".loadajax").show();
            $.ajax({
                url: "{{ route('load.chartMonth') }}",
                type: "POST",
                data: {
                    from_month: from_month,
                    to_month: to_month
                },
                dataType: "json",
                success: function(rsp) {
                    $(".loadajax").hide();
                    if ($.isEmptyObject(rsp.errors)) {
                        chart_month.setData(rsp);
                    } else {
                        confirm_warning(rsp.errors);
                    }
                },
                error: function() {
                    $(".loadajax").hide();
                    alert("error!!!!");
                },
            });
        })

        $(document).on('click', '#btn-filter-year', function() {
            var fromYear = $('#startYear').val() ? $('#startYear').val() : '';
            var toYear = $('#lastYear').val() ? $('#lastYear').val() : '';
            $(".loadajax").show();
            $.ajax({
                url: "{{ route('load.chartYear') }}",
                type: "POST",
                data: {
                    fromYear: fromYear,
                    toYear: toYear
                },
                dataType: "json",
                success: function(rsp) {
                    $(".loadajax").hide();
                    if ($.isEmptyObject(rsp.errors)) {
                        chart_year.setData(rsp);
                    } else {
                        confirm_warning(rsp.errors);
                    }
                },
                error: function() {
                    $(".loadajax").hide();
                    alert("error!!!!");
                },
            });
        })

        $(document).on('click', '.best_sell', function() {
            let select = $(this).val();
            load_product_best_sell(select);
        });

        $(document).on('click', '.top_view', function() {
            let select = $(this).val();
            load_product_top_view(select);
        });

        function load_product_top_view(value) {
            $.ajax({
                url: "{{ route('client.product.rankTopView') }}",
                type: "POST",
                data: {
                    select: value
                },
                dataType: "json",
                success: function(rsp) {
                    $('#' + value).html(rsp);
                },
                error: function() {
                    alert("error!!!!");
                },
            });
        }

        function load_product_best_sell(value) {
            $.ajax({
                url: "{{ route('client.product.rank') }}",
                type: "POST",
                data: {
                    select: value
                },
                dataType: "json",
                success: function(rsp) {
                    $('#' + value).html(rsp);
                },
                error: function() {
                    alert("error!!!!");
                },
            });
        }

        function load_chart() {
            $.ajax({
                url: "{{ route('load.chart') }}",
                type: "POST",
                dataType: "json",
                success: function(rsp) {
                    chart.setData(rsp);
                },
                error: function() {
                    alert("error!!!!");
                },
            });
        }
    </script>
@endsection
