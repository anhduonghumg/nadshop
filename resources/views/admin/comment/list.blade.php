@extends('layouts.admin')
@section('title', 'Danh sách bình luận')
@section('content')
    <style>
        .list_rep {
            list-style-type: decimal;
            color: blue;
            margin: 1px -24px;
        }

        .reply {
            margin: -16px;
        }
    </style>
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
                <h5 class="m-0 ">Danh sách bình luận</h5>
                {{-- <div class="form-search form-inline">
                    <form action="" method="GET">
                        <input type="text" class="form-control form-search" name="kw"
                            value="{{ request()->input('kw') }}" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div> --}}
            </div>
            <div class="card-body">
                {{-- <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Kích
                        hoạt<span class="text-muted">({{ $count[0] }}) |</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ duyệt<span
                            class="text-muted">({{ $count[2] }}) |</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu
                        hóa<span class="text-muted">({{ $count[1] }})</span></a>
                </div> --}}
                <form action="" method="POST">
                    @csrf
                    {{-- <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" name="act" id="">
                            <option>Chọn</option>
                            @foreach ($list_act as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn_action" value="Áp dụng" class="btn btn-primary">
                    </div> --}}
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                {{-- <th scope="col">
                                    <input id="checkall" name="checkall" type="checkbox">
                                </th> --}}
                                <th scope="col">Duyệt</th>
                                <th scope="col">Người gửi</th>
                                <th scope="col">Bình luận</th>
                                <th scope="col">Ngày gửi</th>
                                <th scope="col">Sản phẩm</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_comment as $cmt)
                                <tr>
                                    @if ($cmt->comment_status == 0)
                                        <td>
                                            <input type="button" data-status="1" data-comment="{{ $cmt->id }}"
                                                class="btn btn-sm btn-primary btn_approve" value="Duyệt">
                                        </td>
                                    @else
                                        <td>
                                            <input type="button" data-status="0" data-comment="{{ $cmt->id }}"
                                                class="btn btn-sm btn-danger btn_approve" value="Bỏ duyệt">
                                        </td>
                                    @endif
                                    <td>{{ $cmt->comment_name }}</td>
                                    <td width="40%">
                                        {{ $cmt->comment }}
                                        <ul class="list_rep">
                                            @foreach ($comment_rep as $k => $v)
                                                @if ($v->comment_parent == $cmt->id)
                                                    <span class="text-left reply">Trả lời:</span>
                                                    <li>{{ $v->comment }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        @if ($cmt->comment_status == 1)
                                            <br />
                                            <textarea rows='2' class='reply_comment_{{ $cmt->id }}'></textarea>
                                            <br />
                                            <button type='button' class='btn-reply btn-sm btn-success'
                                                data-comment="{{ $cmt->id }}" data-product={{ $cmt->product_id }}>Trả
                                                lời</button>
                                        @endif
                                    </td>
                                    <td>{{ formatDateToDMY($cmt->comment_date) }}</td>
                                    <td><a
                                            href="{{ route('client.product.detail', $cmt->product_id) }}">{{ $cmt->product_name }}</a>
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>

                                        <a href="" onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                            data-url="" class="btn btn-danger btn-sm rounded-0 text-white action_delete"
                                            type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
                {{ $list_comment->links('layouts.paginationlink') }}
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).on('click', '.btn_approve', function() {
            let status = $(this).data('status');
            let comment = $(this).data('comment');
            $.ajax({
                url: "{{ route('admin.approveComment') }}",
                type: "POST",
                data: {
                    status: status,
                    comment: comment
                },
                dataType: "json",
                success: function(rsp) {
                    if ($.isEmptyObject(rsp.errors)) {
                        confirm_success(rsp.success);
                        location.reload();

                    } else {
                        confirm_warning(rsp.errors);
                    }
                },
                error: function() {
                    //$(".loading").hide();
                    alert("error!!!!");
                }
            });
        })

        $(document).on('click', '.btn-reply', function() {

            let comment_id = $(this).data('comment');
            let comment_product_id = $(this).data('product');
            let comment = $('.reply_comment_' + comment_id).val();

            $.ajax({
                url: "{{ route('admin.replyComment') }}",
                type: "POST",
                data: {
                    comment_id: comment_id,
                    comment_product_id: comment_product_id,
                    comment: comment
                },
                dataType: "json",
                success: function(rsp) {
                    if ($.isEmptyObject(rsp.errors)) {
                        confirm_success(rsp.success);
                    } else {
                        confirm_warning(rsp.errors);
                    }
                },
                error: function() {
                    //$(".loading").hide();
                    alert("error!!!!");
                }
            });

        })
    </script>
@endsection
