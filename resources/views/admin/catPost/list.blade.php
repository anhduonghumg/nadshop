@extends('layouts.admin')
@section('title', 'Danh mục bài viết')
@section('content')
<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm danh mục bài viết
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/post/cat/add') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                id="name">
                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select name="parent_id" class="form-control" id="">
                                <option value="0">Danh mục cha</option>
                                @foreach ($data_cat_post as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="pending" value="pending"
                                    checked>
                                <label class="form-check-label" for="pending">
                                    Chờ duyệt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="public" value="public">
                                <label class="form-check-label" for="public">
                                    Công khai
                                </label>
                            </div>
                        </div>
                        <button type="submit" name="btn_add" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách danh mục bài viết
                </div>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <div class="card-body">
                    <div class="analytic">
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Kích
                            hoạt<span class="text-muted">({{ $count[0] }}) |</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="text-primary">Chờ
                            duyệt<span class="text-muted">({{ $count[2] }}) |</span></a>
                        <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu
                            hóa<span class="text-muted">({{ $count[1] }})</span></a>
                    </div>
                    <form action="{{ url('admin/post/cat/action') }}" method="POST">
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
                                    <th scope="col">Tên</th>
                                    {{-- <th scope="col">Slug</th> --}}
                                    <th scope="col">Danh mục cha</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Người tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($category_post->total() > 0)
                                @php
                                $t = 1;
                                @endphp
                                @foreach ($category_post as $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                    </td>
                                    <th scope="row">{{ $t++ }}</th>
                                    <td>{{ str_repeat('---', $item->level) . $item->name }}</td>
                                    @if ($item->parent_id == 0)
                                    <td>Không có</td>
                                    @else
                                    <td>{{ $item->catPostParent->name }}</td>
                                    @endif
                                    @if ($item->status == 'public')
                                    <td>Công khai</td>
                                    @else
                                    <td>Chờ duyệt</td>
                                    @endif
                                    <td>{{ $item->user->name }}</td>
                                    @if (request()->input('status') == 'trash')
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="#" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                    @else
                                    <td>
                                        <a href="{{ route('admin.catPost.edit', ['id' => $item->id]) }}"
                                            class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.catPost.delete', ['id' => $item->id]) }}"
                                            onclick="return confirm('Bạn muốn xóa bản ghi này?')"
                                            data-url="{{ route('admin.catPost.delete', ['id' => $item->id]) }}"
                                            class="btn btn-danger btn-sm rounded-0 text-white action_delete"
                                            type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i
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
                    {{ $category_post->links('layouts.paginationlink') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection