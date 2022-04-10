@extends('layouts.admin')
@section('title', 'Danh sách bài viết')
@section('content')

    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('errors'))
                <div class="alert alert-danger">
                    {{ session('errors') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
                <div class="form-search form-inline">
                    <form action="" method="GET">
                        <input type="text" class="form-control form-search" name="kw" value="{{ request()->input('kw') }}"
                            placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
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
                        <select class="form-control mr-1" name="act" id="">
                            <option>Chọn</option>
                            @foreach ($list_act as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn_action" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
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
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($list_products->total() > 0)
                                @php
                                    $temp = 0;
                                @endphp
                                @foreach ($list_products as $item)
                                    @php
                                        $temp++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                        </td>
                                        <th scope="row">{{ $temp }}</th>
                                        <td><img src="{{ asset($item->product_thumb) }}" height="80" width="150" alt="">
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
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ route('admin.product.forceDelete', ['id' => $item->id]) }}"
                                                    onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                                    data-url="{{ route('admin.post.forceDelete', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white action_delete"
                                                    type="button" data-toggle="tooltip" data-placement="top"
                                                    title="Delete"><i class="fa fa-trash"></i></a>
                                            </td>
                                        @else
                                            <td>
                                                <button id="add_product_detail" type="button"
                                                    class="btn btn-primary btn-sm rounded-0 text-white" data-toggle="modal"
                                                    data-id="{{ $item->id }}" data-placement="top"
                                                    title="Add product detail" data-token="{{ csrf_token() }}">
                                                    <i class="  fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                                <a href="{{ route('admin.product.edit', ['id' => $item->id]) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
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
                                    <td colspan='7' class="bg-white">
                                        <p>Không có bản ghi nào.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
                {{ $list_products->links('layouts.paginationlink') }}
            </div>
        </div>
    </div>
    {{-- modal add product detail --}}
    <div id="modalPopup">
        <div class="modal fade draggable detail-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby=""
            aria-hidden="true">
            <div class="modal-dialog modal-lg ui-draggable" role="document">
                <div class="modal-content p-3">
                    <form action="route('admin.product.detail')" method='POST' enctype='multipart/form-data'>
                        @csrf
                        <div class="modal-header ui-dranggale-handle" style="cursor: move;">
                            <h5 class="modal-title" id="exampleModalLabel">Thêm chi tiết sản phẩm</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <ul class="nav nav-tabs mt-3 mb-3" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="p_1-tab" data-toggle="tab" href="#p_1" role="tab"
                                    aria-selected="true">Product</a>
                                <span class="remove-product-tab"><i class="fa fa-times" aria-hidden="true"></i>
                                </span>
                            <li class="nav-item"><a class="nav-link" href="#" id="add_work"><i
                                        class="fa fa-plus" aria-hidden="true"></i></a></li>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="p_1" role="tabpanel" aria-labelledby="p_1-tab">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group row">
                                            <label for="product_name" class="col-sm-4 control-label">Tên sản
                                                phẩm:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="product_name"
                                                    placeholder="Tên sản phẩm" name="product_detail_name[]">
                                            </div>
                                        </div>
                                        <div class="form-group row ">
                                            <label for="product_price" class="col-sm-4 control-label">Giá:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="product_price"
                                                    placeholder="Giá sản phẩm (VNĐ)" name="product_price[]">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="product_discount" class="col-sm-4 control-label">Khuyến
                                                mãi:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="product_discount"
                                                    placeholder="Khuyến mãi (%)" name="product_discount[]">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="stock" class="col-sm-4 control-label">Số
                                                lượng:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="stock"
                                                    placeholder="Số lượng sản phẩm" name="product_qty_stock[]">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="color" class="col-sm-4 control-label">Màu:</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="color" name="product_color[]">
                                                    <option selected>Chọn màu</option>
                                                    @foreach ($list_product_color as $item)
                                                        <option value="{{ $item->id }}">{{ $item->color_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="size_ver" class="col-sm-4 control-label">Kích
                                                cỡ/bản:</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" id="size_ver" name="product_size[]">
                                                    <option selected>Chọn kích cỡ/phiên bản</option>
                                                    @foreach ($list_product_size as $item)
                                                        <option value="{{ $item->id }}">{{ $item->size_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group row ">
                                            <label for="" class="col-sm-4 control-label">Ảnh:</label>
                                            <div class="col-sm-8">
                                                <input id="img" type="file" name="thumbnail[]" class="form-control d-none"
                                                    onchange="changeImg(this)">
                                                <img id="avatar" class="img-thumbnail d-block" width="300px"
                                                    src="{{ asset('storage/app/public/images/upload_img.png') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
@endsection
