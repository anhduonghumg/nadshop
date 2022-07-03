@extends('layouts.admin')
@section('title', 'Cập nhập slider')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Cập nhập Slider
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <form action="{{ route('admin.slider.update', $slider->id) }}" method="POST"
                                enctype='multipart/form-data'>
                                @csrf
                                <div class="form-group">
                                    <label for="">Trạng thái</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="slider_status" id="on"
                                            value="on" @if ($slider->slider_status == 'on') return checked @endif>
                                        <label class="form-check-label" for="on">
                                            Hoạt động
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="slider_status" id="off"
                                            value="off" @if ($slider->slider_status == 'off') return checked @endif>
                                        <label class="form-check-label" for="off">
                                            Không hoạt động
                                        </label>
                                    </div>
                                    @error('slider_status')
                                        <small class=" text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" name="slider_update" class="btn btn-primary">Cập nhập</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
