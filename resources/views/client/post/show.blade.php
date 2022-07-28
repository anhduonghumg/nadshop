@extends('layouts.client')
@section('content')
    <style>
        p {
            margin: 0px;
        }
    </style>
    <div class="breadcrumb-shop clearfix px-xl-5 bg-none">
        <div class="padding-lf-40 clearfix">
            <div class="">
                <ol class="breadcrumb breadcrumb-arrows clearfix">
                    <li><a href="{{ route('client.home') }}" target="_self"><i class="fa fa-home"></i>Trang chủ</a><i
                            class="fas fa-angle-double-right breadcrumb-icon"></i></li>
                    <li>Chính sách và quy định chung
                    </li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container">
        <h1 class="mt-5 mb-5">Chính sách và quy định chung</h1>
        <div class="row grid-demo">
            @foreach ($list_posts as $post)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('client.new.detail', $post->id) }}"><img width="290px" height="240px"
                            src="{{ $post->thumbnail }}" alt=""></a>
                    <p>{{ $post->title }}</p>
                    <a href="{{ route('client.new.detail', $post->id) }}">=>xem bài viết</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
