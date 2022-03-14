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
        <div class="card-header font-weight-bold">
            Danh sách bài viết
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Người tạo</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td><img src="http://via.placeholder.com/80X80" alt=""></td>
                        <td>Giá xăng sẽ tiếp tục tăng ở mức cao, lần thứ 4 liên tiếp vào ngày mai?</td>
                        <td>Tin nóng</td>
                        <td>26:06:2020 14:00</td>
                        <td>26:06:2020 14:00</td>
                        <td><button class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip"
                                data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip"
                                data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">Trước</span>
                            <span class="sr-only">Sau</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection