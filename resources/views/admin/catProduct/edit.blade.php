@extends('layouts.admin')
@section('title', 'Cập nhập danh mục sản phẩm')
@section('content')
<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Cập nhập danh mục
                </div>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <div class="card-body">
                    <form action="{{ url("admin/product/cat/update/$catProduct->id") }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="category_product_name">Tên danh mục</label>
                            <input class="form-control @error('category_product_name') is-invalid @enderror" type="text"
                                name="category_product_name" id="category_product_name"
                                value="{{ $catProduct->category_product_name }}">
                            @error('category_product_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select class="form-control" name="parent_id">
                                <option value="0">Danh mục cha</option>
                                @foreach ($data_cat_product as $key => $val)
                                @if ($catProduct->parent_id == $key)
                                <option selected value="{{ $key }}">{{ $val }}</option>
                                @else
                                @if ($catProduct->id == $key)
                                <option hidden value="{{ $key }}">{{ $val }}</option>
                                @else
                                <option value="{{ $key }}">{{ $val }}</option>
                                @endif
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" name="btn_update" class="btn btn-primary">Cập nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection