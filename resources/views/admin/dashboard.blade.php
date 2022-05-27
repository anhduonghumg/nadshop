@extends('layouts.admin')
@section('title','dashboard')
@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                <div class="card-body">
                    <h5 class="card-title">2.680</h5>
                    <p class="card-text">Đơn hàng giao dịch thành công</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐANG XỬ LÝ</div>
                <div class="card-body">
                    <h5 class="card-title">10</h5>
                    <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">DOANH SỐ</div>
                <div class="card-body">
                    <h5 class="card-title">2.5 tỷ</h5>
                    <p class="card-text">Doanh số hệ thống</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG HỦY</div>
                <div class="card-body">
                    <h5 class="card-title">125</h5>
                    <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end analytic  -->
    <div class="card">
        <div class="card-header font-weight-bold">
            THỐNG KÊ BÁN HÀNG
        </div>
        <div class="card-body">
            <form class='d-flex' autocomplete="off">
                <div class="col-md-3">
                    <span for="">Từ ngày</span>
                    <input type="text" name="datepicker" id='datepicker' class='form-control'>
                    <button type="button" id="btn-dashboard-filter" class='btn btn-sm btn-primary'>Lọc</button>
                </div>
                <div class="col-md-3">
                    <span for="">Đến ngày</span>
                    <input type="text" name="datepicker2" id='datepicker2' class='form-control'>
                </div>
                <div class="col-md-3">
                    <span for="">Lọc theo</span>
                    <select class='dashboard-filter form-control'>
                        <option>--Chọn--</option>
                        <option value='lastWeek'>Tuần qua</option>
                        <option value='lastMonth'>Tháng qua</option>
                        <option value='thisMonth'>Tháng này</option>
                        <option value='lastYear'>Năm qua</option>
                    </select>
                </div>
            </form>
            <div class="col-md-12">
                <div id="chart" style="height:250px;"></div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header font-weight-bold">
            ĐƠN HÀNG MỚI
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mã</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Giá trị</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>1212</td>
                        <td>
                            Phan Văn Cương <br>
                            0988859692
                        </td>
                        <td><a href="#">Samsung Galaxy A51 (8GB/128GB)</a></td>
                        <td>1</td>
                        <td>7.790.000₫</td>
                        <td><span class="badge badge-warning">Đang xử lý</span></td>
                        <td>26:06:2020 14:00</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                    class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>1213</td>
                        <td>
                            Minh Anh <br>
                            0868873382
                        </td>
                        <td><a href="#">Samsung Galaxy A51 (8GB/128GB)</a></td>
                        <td>1</td>
                        <td>7.790.000₫</td>
                        <td><span class="badge badge-warning">Đang xử lý</span></td>
                        <td>26:06:2020 14:00</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                    class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>1214</td>
                        <td>
                            Trần Thu Hằng <br>
                            0234343545
                        </td>
                        <td><a href="#">Điện thoại iPhone 11 Pro Max 64GB</a></td>
                        <td>1</td>
                        <td>29.490.000₫</td>
                        <td><span class="badge badge-success">Hoàn thành</span></td>
                        <td>26:06:2020 14:00</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                    class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>1212</td>
                        <td>
                            Tuấn Anh <br>
                            091236768
                        </td>
                        <td><a href="#">Apple MacBook Pro Touch 2020 i5 512GB</a></td>
                        <td>1</td>
                        <td>47.990.000₫</td>
                        <td><span class="badge badge-warning">Đang xử lý</span></td>
                        <td>26:06:2020 14:00</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                    class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>1214</td>
                        <td>
                            Trần Thu Hằng <br>
                            0234343545
                        </td>
                        <td><a href="#">Điện thoại iPhone 11 Pro Max 64GB</a></td>
                        <td>1</td>
                        <td>29.490.000₫</td>
                        <td><span class="badge badge-success">Hoàn thành</span></td>
                        <td>26:06:2020 14:00</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                    class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>1212</td>
                        <td>
                            Tuấn Anh <br>
                            091236768
                        </td>
                        <td><a href="#">Apple MacBook Pro Touch 2020 i5 512GB</a></td>
                        <td>1</td>
                        <td>47.990.000₫</td>
                        <td><span class="badge badge-success">Hoàn thành</span></td>
                        <td>26:06:2020 14:00</td>
                        <td>
                            <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                    class="fa fa-trash"></i></a>
                        </td>
                    </tr>

                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">Trước</span>
                            <span class="sr-only">Sau</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<script type="text/javascript">
    $( function() {
        $( "#datepicker" ).datepicker({
          dateFormat: "dd/mm/yy",
          dayNamesMin: ["T2","T3","T4","T5","T6","T7","CN"],
        });
        $( "#datepicker2" ).datepicker({
            dateFormat: "dd/mm/yy",
            dayNamesMin: ["T2","T3","T4","T5","T6","T7","CN"],
          });
      });
</script>

<script type="text/javascript">
    load_chart();

    var chart = new Morris.Bar({
        element: 'chart',
        lineColors: ['#819C79','#fc8710','#FF6541','#A4ADD3','#766B56'],
        parseTime: false,
        hideHover: 'auto',
        gridTextSize: 12,
        xkey: 'period',
        ykeys: ['order','sales','profit','qty'],
        labels: ['Đơn hàng','Doanh số','Lợi nhuận','Số lượng']
      });

    $(document).on('click','#btn-dashboard-filter',function(){
        var from_date = $('#datepicker').val();
        var to_date = $('#datepicker2').val();
        //$(".loadajax").show();
        $.ajax({
            url: "{{ route('dashboard.filter.date') }}",
            type: "POST",
            data: { from_date:from_date,to_date:to_date },
            dataType: "json",
            success: function (rsp) {
              chart.setData(rsp);
            },error: function () {
           alert("error!!!!");
            },
        });
    })

    $(document).on('change','.dashboard-filter',function(){
        var filter = $(this).val();
        $.ajax({
            url: "{{ route('dashboard.filter') }}",
            type: "POST",
            data: { filter:filter },
            dataType: "json",
            success: function (rsp) {
              chart.setData(rsp);
            },error: function () {
           alert("error!!!!");
            },
        });
    })

    function load_chart(){
        $.ajax({
            url: "{{ route('load.chart') }}",
            type: "POST",
            //data: { filter:filter },
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
