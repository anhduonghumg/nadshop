@extends('layouts.admin')
@section('title', 'Danh sách khách hàng')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách khách hàng</h5>
                {{-- <div class="form-search form-inline">
                    <form action="" method="GET">
                        <input type="text" class="form-control form-search" name="keyword"
                            value="{{ request()->input('keyword') }}" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div> --}}
            </div>
            <div class="card-body">
                {{-- <div class="analytic">
                    <a href="" class="text-primary">Tất cả<span class="text-muted">(10) |</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Kích
                        hoạt<span class="text-muted">({{ $count[0] }}) |</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu
                        hóa<span class="text-muted">({{ $count[1] }})</span></a>
                </div> --}}
                <form action="" method="POST">
                    @csrf
                    <div class="form-action form-inline py-3 d-flex">
                        {{-- <select class="form-control mr-1" name="act" id="">
                            <option>Chọn</option>
                            @foreach ($list_act as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select> --}}
                        <a href="{{ route('admin.customer.export') }}" name="export_excel"
                            class="btn btn-success export_excel mr-3">Xuất excel</a>
                        <a href="{{ route('admin.customer.sendCoupon') }}" name="send_coupon"
                            class="btn btn-secondary send_coupon">Gửi mã giảm giá</a>
                    </div>
                    <table class="table table-striped table-checkall customer_table">
                        <thead>
                            <tr>
                                <th width="5%">
                                    <input id="checkall" name="checkall" type="checkbox">
                                </th>
                                <th scope="col" width="5%">STT</th>
                                <th scope="col" width="20%">Họ tên</th>
                                <th scope="col" width="15%">Email</th>
                                <th scope="col" width="10%">SĐT</th>
                                <th scope="col" width="10%">SP đã mua</th>
                                <th scope="col" width="20%">Đã tiêu</th>
                                <th scope="col" width="10%">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $temp=0; @endphp
                            @foreach ($customer as $item)
                                @php $temp++ @endphp
                                <tr>
                                    <td>
                                        <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                    </td>
                                    <td scope="row">{{ $temp }}</td>
                                    <td scope="row">{{ $item->fullname }}</td>
                                    <td scope="row">{{ $item->email }}</td>
                                    <td scope="row">{{ $item->phone }}</td>
                                    <td scope="row">{{ $item->total_order }}</td>
                                    <td scope="row">{{ currentcyFormat($item->total_spend) }}</td>
                                    <td class="text-center">
                                        <span style="cursor: pointer;" class="gift" data-id="{{ $item->id }}"><i
                                                class="fa fa-gift" aria-hidden="true"></i></span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
                {{-- {{ $customer->links('layouts.paginationlink') }} --}}
            </div>
        </div>
        <script>
            // $('.customer_table').DataTable();
            $(".customer_table").DataTable({
                pageLength: 20,
                lengthChange: false,
                drawCallback: function(settings) {
                    if ($(this).find('tbody tr').length < 20) {
                        $('.dataTables_paginate').hide();
                    }
                }
            });
        </script>
    @endsection
