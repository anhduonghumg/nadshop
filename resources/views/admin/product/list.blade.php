@extends('layouts.admin')
@section('title', 'Danh sách bài viết')
@section('content')
    <style>
        #form-excel {
            position: absolute;
            top: 122px;
            left: 598px;
        }
    </style>
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif @if (session('errors'))
                    <div class="alert alert-danger">
                        {{ session('errors') }}
                    </div>
                @endif
                <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Danh sách sản phẩm</h5>
                    <div class="form-search form-inline">
                        <form action="" method="GET">
                            <input type="text" class="form-control form-search" name="kw"
                                value="{{ request()->input('kw') }}" placeholder="Tìm kiếm" />
                            <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary" />

                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Kích
                            hoạt<span class="text-muted">({{ $count[0] }}) |</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ
                            duyệt<span class="text-muted">({{ $count[2] }}) |</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu
                            hóa<span class="text-muted">({{ $count[1] }})</span></a>
                    </div>
                    <form action="{{ route('admin.product.action') }}" method="POST">
                        @csrf
                        <div class="form-action form-inline py-3">
                            <section class='action'>
                                <select class="form-control mr-1" name="act" id="">
                                    <option>Chọn</option>
                                    @foreach ($list_act as $k => $v)
                                        <option value="{{ $k }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                                <input type="submit" name="btn_action" value="Áp dụng" class="btn btn-primary" />
                            </section>
                            @if (request()->input('status') == Constants::ACTIVE || !request()->input('status'))
                                <section class='filter'>
                                    {{-- <form action="{{ route('admin.product.filter') }}" method="POST"> --}}
                                    <select class="form-control ml-3 mr-1" name="product_filter" id="product_filter">
                                        <option value="">Chọn</option>
                                        <option value="new">Sản phẩm mới</option>
                                        <option value="best_sell">Sản phẩm bán chạy</option>
                                        <option value="top_view">Sản phẩm xem nhiều</option>
                                    </select>
                                    <button type="button" id="btn_filter" name="btn_filter"
                                        class="btn btn-primary">Lọc</button>
                                    {{-- </form> --}}
                                </section>
                                <a href="{{ route('admin.product.add') }}" type="button" class="btn btn-primary ml-3"
                                    name='btn_add_new_product'>Thêm mới</a>
                            @endif
                        </div>
                        <div id="show_filter_data">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <input id="checkall" name="checkall" type="checkbox" />
                                        </th>
                                        <th scope="col">STT</th>
                                        <th scope="col">Ảnh</th>
                                        <th scope="col">Tên sản phẩm</th>
                                        <th scope="col">Danh mục</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Người tạo</th>
                                        @if (request()->input('status') == Constants::TRASH)
                                            <th scope="col">Ngày xóa</th>
                                        @else
                                            <th scope="col">Ngày tạo</th>
                                        @endif
                                        @if (request()->input('status') == Constants::PUBLIC || !request()->input('status'))
                                            <th scope="col">Phiên bản</th>
                                        @endif
                                        <th scope="col">Tác vụ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($list_products->total() > 0) @php $temp = 0; @endphp
                                        @foreach ($list_products as $item)
                                            @php $temp++; @endphp
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="list_check[]"
                                                        value="{{ $item->id }}" />
                                                </td>
                                                <th scope="row">{{ $temp }}</th>
                                                <td>
                                                    <img src="{{ asset($item->product_thumb) }}" height="80"
                                                        width="150" alt="" />
                                                </td>
                                                <td>{{ $item->product_name }}</td>
                                                <td>{{ $item->category_product_name }}</td>
                                                @if ($item->product_status == Constants::PUBLIC)
                                                    <td>Công khai</td>
                                                @elseif($item->product_status == Constants::PENDING)
                                                    <td>Chờ duyệt</td>
                                                @else
                                                    <td>Vô hiệu hóa</td>
                                                @endif
                                                <td>{{ $item->fullname }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                @if (request()->input('status') == Constants::TRASH)
                                                    <td>
                                                        <a href="{{ route('admin.product.edit', ['id' => $item->id]) }}"
                                                            class="btn btn-success btn-sm rounded-0 text-white"
                                                            type="button" data-toggle="tooltip" data-placement="top"
                                                            title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="{{ route('admin.product.forceDelete', ['id' => $item->id]) }}"
                                                            onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                                            data-url="{{ route('admin.post.forceDelete', ['id' => $item->id]) }}"
                                                            class="btn btn-danger btn-sm rounded-0 text-white action_delete"
                                                            type="button" data-toggle="tooltip" data-placement="top"
                                                            title="Delete"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                @else
                                                    <td><a href="{{ route('admin.product.variant', ['id' => $item->id]) }}"
                                                            class='btn_variant'>Danh sách</a></td>
                                                    <td>
                                                        <input type="hidden" class="data-img"
                                                            data-img="{{ asset('storage/app/public/images/upload_img.png') }}" />
                                                        <button id="add_product_detail" type="button"
                                                            class="btn btn-primary btn-sm rounded-0 text-white"
                                                            data-toggle="modal" data-id="{{ $item->id }}"
                                                            data-url="{{ route('admin.product.detail.add') }}"
                                                            data-placement="top" title="Add product detail"
                                                            data-token="{{ csrf_token() }}">
                                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                                        </button>
                                                        <a href="{{ route('admin.product.edit', ['id' => $item->id]) }}"
                                                            class="btn btn-success btn-sm rounded-0 text-white"
                                                            type="button" data-toggle="tooltip" data-placement="top"
                                                            title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="{{ route('admin.product.delete', ['id' => $item->id]) }}"
                                                            onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                                            data-url="{{ route('admin.product.delete', ['id' => $item->id]) }}"
                                                            class="btn btn-danger btn-sm rounded-0 text-white action_delete"
                                                            type="button" data-toggle="tooltip" data-placement="top"
                                                            title="Delete"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="bg-white">
                                                <p>Không có bản ghi nào.</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            {{ $list_products->links('layouts.paginationlink') }}
                        </div>
                    </form>
                    <form action="{{ route('admin.product.export') }}" method="POST" id="form-excel">
                        @csrf
                        <input type="submit" id="export_excel" value="Xuất excel" name="export_csv"
                            class="btn btn-success ml-2">
                    </form>
                </div>
        </div>
    </div>
    {{-- modal add product detail --}}
    <div id="modalPopup">
    </div>
    <script type="text/javascript">
        $(document).on('click', '#btn_filter', function() {
            let filter = $('#product_filter').val();
            $(".loadajax").show();
            load_filter(filter, 1);
        });

        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            // var url = "http://localhost:8080/nadshop/admin/product/detail/list";
            let filter = $('#product_filter').val();
            let page = $(this).attr('href').split('page=')[1];
            /*
            var query = $('.keyword').val();
            if (query != "") {
                history.pushState(null, '', url + "?page=" + page + "&kw=" + query);
            } else {
                history.pushState(null, '', url + "?page=" + page);
            }
            */
            load_filter(filter, page);
            // alert(filter);
        });

        // $(document).on('click', '#export_excel', function() {
        //     $.ajax({
        //         url: "{{ route('admin.product.export') }}",
        //         type: "POST",
        //         dataType: "html",
        //         success: function(rsp) {
        //             alert('xuất thành công');
        //         },
        //         error: function() {
        //             alert("error!!!!");
        //         },
        //     });
        // });

        function load_filter(data, page) {
            $.ajax({
                url: "{{ route('admin.product.filter') }}" + "?page=" + page,
                type: "POST",
                dataType: "html",
                data: {
                    filter: data
                },
                success: function(rsp) {
                    $(".loadajax").hide();
                    $('#show_filter_data').html(rsp);
                },
                error: function() {
                    $(".loadajax").hide();
                    alert("error!!!!");
                },
            });
        }
    </script>
@endsection
