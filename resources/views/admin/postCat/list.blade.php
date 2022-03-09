@extends('layouts.admin')
@section('title', 'Danh mục bài viết')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh mục bài viết
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
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
                                    @foreach ($data_select as $key => $val)
                                        <option value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" name="btn_add" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên</th>
                                    {{-- <th scope="col">Slug</th> --}}
                                    <th scope="col">Danh mục cha</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 1;
                                @endphp
                                @foreach ($data_catPosts as $item)
                                    <tr>
                                        <th scope="row">{{ $t++ }}</th>
                                        <td>{{ str_repeat('---', $item->level) . $item->name }}</td>
                                        <td>{{ $item->slug }}</td>
                                        @if ($item->parent_id == 0)
                                            <td>Không có</td>
                                        @else
                                            <td>{{ $item->catPostParent->name }}</td>
                                        @endif
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $catPosts->links('layouts.paginationlinks') }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
