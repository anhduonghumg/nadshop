{{-- <div class="analytic">
    <a href="{{ request()->url() }}" class="text-primary">Kích hoạt<span class="text-muted">|</span></a>
    <a href="{{ request()->url() }}?satus=pending" class="text-primary">Chờ duyệt<span class="text-muted">
            |</span></a>
    <a href="{{ request()->url() }}?status=trash" class="text-primary">Vô hiệu hóa<span class="text-muted"></span></a>
</div> --}}
{{-- <form action="{{ route('admin.product.action') }}" method="POST"> --}}
{{-- @csrf --}}
<div class="form-action form-inline py-3">
    {{-- <select class="form-control mr-1" name="act" id="">
            <option>Chọn</option>
            @foreach ($list_act as $k => $v)
            <option value="{{ $k }}">{{ $v }}</option>
            @endforeach
        </select> --}}
    <input type="submit" name="btn_action" value="Áp dụng" class="btn btn-primary" />
    <button type="button" id="add_variant" class="btn btn-primary btn_add_variant ml-3" name="btn_add_variant">Thêm
        mới</button>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Ảnh</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Giá</th>
            <th scope="col">Ngày tạo</th>
            <th scope="col">Trạng thái</th>
            <th scope="col">Tác vụ</th>
        </tr>
    </thead>
    <tbody>
        @if ($list_product_details->total() > 0)
            @php
                $temp = 0;
            @endphp
            @foreach ($list_product_details as $item)
                @php
                    $temp++;
                @endphp
                <tr>
                    <th scope="row">{{ $temp }}</th>
                    <td>
                        <img src="{{ asset($item->product_details_thumb) }}" width="80px" height="80px"
                            alt="" />
                    </td>
                    <td>{{ $item->product_detail_name }}</td>
                    <td>{{ currentcyFormat($item->product_price) }}</td>
                    <td>{{ formatDateToDMY($item->created_at) }}</td>
                    @if ($item->product_qty_stock > 0)
                        <td>
                            <span class="badge badge-success">Còn hàng</span>
                        </td>
                    @else
                        <td>
                            <span class="badge badge-dark">Hết hàng</span>
                        </td>
                    @endif
                    <td>
                        <a class="btn btn-success btn-sm rounded-0 text-white edit-prodetail" type="button"
                            data-id="{{ $item->id }}" data-url="{{ route('admin.product.detail.edit') }}"
                            data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                        <a class="btn btn-danger btn-sm rounded-0 text-white delete-prodetail" type="button"
                            data-id="{{ $item->id }}" data-url="{{ route('admin.product.detail.delete') }}"
                            data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                        <a class="btn btn-primary btn-sm rounded-0 text-white show-prodetail" type="button"
                            data-id="{{ $item->id }}" data-url="" data-placement="top" title="Detail"><i
                                class="fa fa-asterisk" aria-hidden="true"></i></a>
                    </td>
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
{{-- </form> --}}
{{ $list_product_details->links('layouts.paginationlink') }}
