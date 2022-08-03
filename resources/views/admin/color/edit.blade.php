@extends('layouts.admin')
@section('title', 'Cập nhập thương hiệu')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Cập nhập màu
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <form action="{{ route('admin.color.update', ['id' => $color->id]) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Tên màu</label>
                                    <input class="form-control @error('color_name') is-invalid @enderror" type="text"
                                        name="color_name" id="color_name" value="{{ $color->color_name }}">
                                    @error('color_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="code_color">Mã màu</label>
                                    <input class="form-control" type="text" name="code_color" id="code_color" value="{{ $color->code_color }}">
                                    @error('code_color')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" name="btn_update" class="btn btn-primary">Cập nhập</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
