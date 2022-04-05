@extends('layouts.admin')
@section('title','Danh sách bài viết')
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
            <h5 class="m-0 ">Danh sách bài viết</h5>
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
                <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ duyệt<span
                        class="text-muted">({{ $count[2] }}) |</span></a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu
                    hóa<span class="text-muted">({{ $count[1] }})</span></a>
            </div>
            <form action="{{ url('admin/post/action') }}" method="POST">
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
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Người tạo</th>
                            @if(request()->input('status') == 'trash')
                            <th scope="col">Ngày xóa</th>
                            @else
                            <th scope="col">Ngày tạo</th>
                            @endif
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($list_posts->total() > 0)
                        @php
                        $temp=0;
                        @endphp
                        @foreach ($list_posts as $item)
                        @php
                        $temp++;
                        @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                            </td>
                            <th scope="row">{{ $temp }}</th>
                            <td><img src="{{ asset($item->thumbnail) }}" height="80" width="150" alt=""></td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->name }}</td>
                            @if ($item->status == Constants::PUBLIC)
                            <td>Công khai</td>
                            @elseif($item->status == Constants::PENDING)
                            <td>Chờ duyệt</td>
                            @else
                            <td>Vô hiệu hóa</td>
                            @endif
                            <td>{{ $item->fullname }}</td>
                            <td>{{ $item->created_at }}</td>
                            @if (request()->input('status') == Constants::TRASH)
                            <td>
                                <a href="{{ route('admin.post.edit', ['id' => $item->id]) }}"
                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                        class="fa fa-edit"></i></a>
                                <a href="{{ route('admin.post.forceDelete', ['id' => $item->id]) }}"
                                    onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                    data-url="{{ route('admin.post.forceDelete', ['id' => $item->id]) }}"
                                    class="btn btn-danger btn-sm rounded-0 text-white action_delete" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                        class="fa fa-trash"></i></a>
                            </td>
                            @else
                            <td>
                                <a href="{{ route('admin.post.edit', ['id' => $item->id]) }}"
                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                        class="fa fa-edit"></i></a>
                                <a href="{{ route('admin.post.delete', ['id' => $item->id]) }}"
                                    onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                    data-url="{{ route('admin.post.delete', ['id' => $item->id]) }}"
                                    class="btn btn-danger btn-sm rounded-0 text-white action_delete" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                        class="fa fa-trash"></i></a>
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
            {{ $list_posts->links('layouts.paginationlink') }}
        </div>
    </div>
</div>
@endsection
