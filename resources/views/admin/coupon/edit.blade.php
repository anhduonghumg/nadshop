@extends('layouts.admin')
@section('title', 'Cập nhập mã giảm giá')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Cập nhập mã giảm giá
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <form action="{{ route('admin.coupon.update', ['id' => $coupon->id]) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="code">Mã giảm giá</label>
                                    <input class="form-control" type="text" name="code" id="code"
                                        value="{{ $coupon->code }}">
                                    @error('code')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="value">Giá trị</label>
                                    <input class="form-control" type="text" name="value" id="value"
                                        value="{{ $coupon->value }}">
                                    @error('value')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="qty">Số lượng</label>
                                    <input class="form-control" type="number" name="qty" id="qty" min="1"
                                        value="{{ $coupon->qty }}">
                                    @error('qty')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                @if ($coupon->status == 'on')
                                    <div class="form-group">
                                        <label for="">Trạng thái</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="on"
                                                value="on" checked>
                                            <label class="form-check-label" for="on">
                                                Hoạt động
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="off"
                                                value="off">
                                            <label class="form-check-label" for="off">
                                                Không hoạt động
                                            </label>
                                        </div>
                                        @error('status')
                                            <small class=" text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label for="">Trạng thái</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="on"
                                                value="on">
                                            <label class="form-check-label" for="on">
                                                Hoạt động
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="off"
                                                value="off" checked>
                                            <label class="form-check-label" for="off">
                                                Không hoạt động
                                            </label>
                                        </div>
                                        @error('status')
                                            <small class=" text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                @endif
                                <button type="submit" name="coupon_update" class="btn btn-primary">Cập nhập</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
