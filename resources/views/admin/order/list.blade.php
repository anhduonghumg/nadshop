@extends('layouts.admin')
@section('title','Danh sách đơn hàng')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Danh sách đơn hàng
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{ route('admin.order.list','status=all') }}" class="text-primary">Tất cả<span
                        class="text-muted"> |</span></a>
                <a href="{{ route('admin.order.list','status=pending') }}" class="text-primary">Chờ xác nhận<span
                        class="text-muted">|</span></a>
                <a href="{{ route('admin.order.list','status=confirm') }}" class="text-primary">Đã xác nhận<span
                        class="text-muted">|</span></a>
                <a href="{{ route('admin.order.list','status=complete') }}" class="text-primary">Hoàn thành<span
                        class="text-muted">|</span></a>
                <a href="{{ route('admin.order.list','status=cancel') }}" class="text-primary">Hủy bỏ<span
                        class="text-muted"></span></a>
            </div>
            {{-- <form> --}}
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" name="act" id="">
                        <option>Chọn</option>
                        <option>Xác nhận</option>
                        <option>Hoàn thành</option>
                        <option>Hủy bỏ</option>
                    </select>
                    <input type="submit" name="btn_action" value="Áp dụng" class="btn btn-primary mr-3">
                    <a href="{{ route('admin.order.add') }}" class="btn btn-success btn-rounded btn-add"><i
                            class="fa fa-plus"></i> Thêm
                        mới</a>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input id="checkall" name="checkall" type="checkbox">
                            </th>
                            <th scope="col">STT</th>
                            <th scope="col">Mã</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Giá trị</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thanh toán</th>
                            <th scope="col">Chi tiết </th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="">
                            </td>
                            <th scope="row">1</th>
                            <td><strong>#1112</strong></td>
                            <td>
                                Phan Văn Cương
                            </td>
                            <td>22/5/2022</td>
                            <td>$120</td>
                            <td>
                                <span class="badge badge-warning">Đang xử lý</span>
                            </td>
                            <td>COD</td>
                            <td><button type="button" class="btn btn-primary btn-sm btn-rounded">Xem chi tiết</button>
                            </td>
                            <td>
                                <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                        class="fa fa-edit"></i></a>
                                <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                        class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                {{--
            </form> --}}
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
<div id="modalPopup">
    <div class="modal fade draggable edit-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
        <div class="modal-dialog modal-lg ui-draggable">
            <div class="modal-content p-3">
                <form method='POST'>
                    <div class="modal-header ui-dranggale-handle" style="cursor: move;">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm đơn hàng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="form-group">
                            <label for="fullname">Tên khách hàng</label>
                            <input type="text" class="form-control" id="fullname" name="fullname"
                                placeholder="Nhập tên khách hàng...">
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Nhập số điện thoại...">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Nhập email...">
                        </div>
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="Nhập địa chỉ...">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                {{-- <label for="city">Tỉnh/Thành phố</label> --}}
                                <select class="custom-select form-control" id="city" required="">
                                    <option value="">Tỉnh/Thành phố</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                {{-- <label for="state">Quận/Huyện</label> --}}
                                <select class="custom-select form-control" id="state" required="">
                                    <option value="">Quận/Huyện</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="order_status">Trạng thái đơn hàng</label>
                            <select class="custom-select form-control" id="order_status" name="order_status"
                                required="">
                                <option value="">Chọn trang thái đơn hàng</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="order_status">Hình thức thanh toán</label><br>
                            <input type="radio" id="cod" name="payment" value="cod">
                            <label for="cod" class="mr-3">COD</label>
                            <input class="ml-3" type="radio" id="card" name="payment" value="card">
                            <label for="card">Card</label><br>
                        </div>
                        <div class="form-group">
                            <label for="note">Ghi chú</label>
                            <textarea class="form-control" rows="3" id="note" name="note"></textarea>
                        </div>
                        <div class="form-group">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First</th>
                                        <th scope="col">Last</th>
                                        <th scope="col">Handle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td>Larry</td>
                                        <td>the Bird</td>
                                        <td>@twitter</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <input type="submit" name="btn_save" value="Thêm mới" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{--  <script>
    $(document).on('click','.btn-add',function(){
$(".modal").modal('show');
    });
</script>  --}}
@endsection
