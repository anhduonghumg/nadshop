@extends('layouts.admin')
@section('title', 'Cập nhập thương hiệu')
@section('content')
<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Cập nhập Size
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('admin.size.update', ['id' => $size->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="size_name">Tên size</label>
                                <input class="form-control @error('size_name') is-invalid @enderror" type="text"
                                    name="size_name" id="size_name" value="{{ $size->size_name }}">
                                @error('size_name')
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
