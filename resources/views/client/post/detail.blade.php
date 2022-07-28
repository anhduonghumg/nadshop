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
                    <li><a href="{{ route('client.news') }}" target="_self">{{ $post->category_post_name }}</a><i
                            class="fas fa-angle-double-right breadcrumb-icon"></i></li>
                    <li>{{ $post->title }}</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container">
        <h4 class="mt-5 mb-5 text-red">{{ $post->title }}</h4>
        <h6>{!! $post->desc !!}</h6>
        <article>{!! $post->content !!}</article>
    </div>
@endsection
