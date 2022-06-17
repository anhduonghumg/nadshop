@extends('layouts.client')
@section('content')
<div class="breadcrumb-shop clearfix bg-none px-xl-5">
    <div class="clearfix">
        <div class="">
            <ol class="breadcrumb breadcrumb-arrows clearfix">
                <li><a href="{{ route('client.cart.show') }}" target="_self"><i
                            class="fas fa-shopping-cart text-primary"></i>Giỏ hàng</a><i
                        class="fas fa-angle-double-right breadcrumb-icon"></i></li>
                <li>Thanh toán</li>
            </ol>
        </div>
    </div>
</div>
<div class="container-fluid pt-5">
    <h4 class="font-weight-semi-bold mb-4 px-xl-5">Thông tin đơn hàng</h4>
    <div class="row px-xl-5">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Họ và tên</label>
                <input class="form-control" type="text" placeholder="Họ và tên">
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input class="form-control" type="text" placeholder="Số điện thoại">
            </div>
            <div class="form-group">
                <label>Địa chỉ</label>
                <input class="form-control" type="text" placeholder="Địa chỉ">
            </div>
            <div class="form-group">
                <label>Tỉnh/Thành phố</label>
                <select class="form-control" name="city">
                    <option>Hà Nội</option>
                    <option>Hồ Chí Minh</option>
                </select>
            </div>
            <div class="form-group">
                <label>Quận/Huyện</label>
                <select class="form-control" name="">
                    <option>Hà Nam</option>
                    <option>Hà Trung</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ghi Chú</label>
                <textarea class="form-control" rows="5" placeholder="Ghi chú"></textarea>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-secondary mb-5">
                {{-- <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                </div> --}}
                <div class="card-body">
                    <h5 class="font-weight-medium mb-3">Sản phẩm</h5>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <img src="" alt="">
                                    <td>Áo phông 00921</td>
                                    <td>
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-minus btn_qty">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text"
                                                class="form-control form-control-sm bg-secondary text-center product_quantity"
                                                value="1" data-key="0" data-id="59">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-primary btn-plus btn_qty">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>120.000đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="mt-0">
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Phí vận chuyển</h6>
                        <h6 class="font-weight-medium">Chọn nhà vận chuyển</h6>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Tổng cộng:</h5>
                        <h5 class="font-weight-bold">500.0000đ</h5>
                    </div>
                </div>
            </div>
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Phương thức thanh toán</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="paypal">
                            <label class="custom-control-label" for="paypal">COD</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" name="payment" id="directcheck">
                            <label class="custom-control-label" for="directcheck">MOMO</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Hoàn tất đơn
                        hàng</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Checkout End -->
@endsection
