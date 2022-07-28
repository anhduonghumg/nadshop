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
            <th scope="col">Phiên bản</th>
            <th scope="col">Tác vụ</th>
        </tr>
    </thead>
    <tbody>
        @if ($list_products->total() > 0) @php $temp = 0; @endphp
            @foreach ($list_products as $item)
                @php $temp++; @endphp
                <tr>
                    <td>
                        <input type="checkbox" name="list_check[]" value="{{ $item->id }}" />
                    </td>
                    <th scope="row">{{ $temp }}</th>
                    <td>
                        <img src="{{ asset($item->product_thumb) }}" height="80" width="150" alt="" />
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
                                class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('admin.product.forceDelete', ['id' => $item->id]) }}"
                                onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                data-url="{{ route('admin.post.forceDelete', ['id' => $item->id]) }}"
                                class="btn btn-danger btn-sm rounded-0 text-white action_delete" type="button"
                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                    class="fa fa-trash"></i></a>
                        </td>
                    @else
                        <td><a href="{{ route('admin.product.variant', ['id' => $item->id]) }}"
                                class='btn_variant'>Danh sách</a>
                        </td>
                        <td>
                            {{-- <input type="hidden" class="data-img"
                                data-img="{{ asset('storage/app/public/images/upload_img.png') }}" />
                            <button id="add_product_detail" type="button"
                                class="btn btn-primary btn-sm rounded-0 text-white" data-toggle="modal"
                                data-id="{{ $item->id }}"
                                data-url="{{ route('admin.product.detail.add') }}"
                                data-placement="top" title="Add product detail" data-token="{{ csrf_token() }}">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button> --}}
                            <a href="{{ route('admin.product.edit', ['id' => $item->id]) }}"
                                class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                            <a href="{{ route('admin.product.delete', ['id' => $item->id]) }}"
                                onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                data-url="{{ route('admin.product.delete', ['id' => $item->id]) }}"
                                class="btn btn-danger btn-sm rounded-0 text-white action_delete" type="button"
                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                    class="fa fa-trash"></i></a>
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
