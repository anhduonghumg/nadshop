@extends('layouts.admin')
@section('title', 'Cập nhập thương hiệu')
@section('content')
<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Cập nhập thương hiệu
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('admin.brand.update', ['id' => $brand->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên thương hiệu</label>
                                <input class="form-control @error('brand_name') is-invalid @enderror" type="text"
                                    name="brand_name" id="brand_name" value="{{ $brand->brand_name }}">
                                @error('brand_name')
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
