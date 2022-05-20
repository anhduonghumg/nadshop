@extends('layouts.admin')
@section('title','Danh sách quyền')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5>Danh sách quyền</h5>
        </div>
        <div class="card-body">
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" name="act" id="act">
                    <option value="">Chọn</option>
                </select>
                <input type="button" name="btn_action" value="Áp dụng" class="btn btn-primary mr-3">
                <button class="btn btn-success btn-rounded add_role"><i class="fa fa-plus"></i> Thêm
                    mới</button>
            </div>
           
        </div>
    </div>
    <div id="modalPopup">
    </div>
    {{-- <script type="text/javascript">
        loadRole();
    $(document).on('click','.add_role',function(){
        $('.loadajax').show();
        $.ajax({
            url: "{{ route('admin.role.add') }}",
            type: "GET",
            dataType: "html",
            success: function (rsp) {
                $('.loadajax').hide();
              $('#modalPopup').html(rsp);
            $('.modal').modal('show');
            },error: function () {
                alert("error!!!!");
            },
        });
});

$(document).on('click','#save_role',function(){
    var data = $('#fm_add_role').serializeArray();
    $('.loadajax').show();
    $.ajax({
        url: "{{ route('admin.role.store') }}",
        type: "POST",
        data: data,
        dataType: "json",
        success: function (rsp) {
            $('.loadajax').hide();
            if ($.isEmptyObject(rsp.errors)) {
                confirm_success(rsp.success);
                $('.modal').modal('hide');
                loadRole();
            } else {
                confirm_warning(rsp.errors);
            }
        },error: function () {
            alert("error!!!!");
        },
    });
});

$(document).on('click','.edit-role',function(){
    $('.loadajax').show();
    var id = $(this).data('id');
    $.ajax({
        url: "{{ route('admin.role.edit') }}",
        type: "GET",
        data: {id:id},
        dataType: "html",
        success: function (rsp) {
            $('.loadajax').hide();
          $('#modalPopup').html(rsp);
        $('.modal').modal('show');
        },error: function () {
            alert("error!!!!");
        },
    });

});

$(document).on('click','#update_role',function(){
    var data = $('#fm_update_role').serializeArray();
    $('.loadajax').show();
    $.ajax({
        url: "{{ route('admin.role.update') }}",
        type: "POST",
        data: data,
        dataType: "json",
        success: function (rsp) {
            $('.loadajax').hide();
            if ($.isEmptyObject(rsp.errors)) {
                confirm_success(rsp.success);
                $('.modal').modal('hide');
                loadRole();
            } else {
                confirm_warning(rsp.errors);
            }
        },error: function () {
            alert("error!!!!");
        },
    });
});

$(document).on('click','.delete-role',function(){
    var id = $(this).attr("data-id");
    $.ajax({
        url: "{{ route('admin.role.delete') }}",
        type: "POST",
        dataType: "json",
        data: {id:id},
        beforeSend:function(){
           return confirm("Bạn thực sự muốn xóa?");
         },
        success: function (rsp) {
            $(".loadajax").hide();
            confirm_success(rsp.success);
            loadRole();
        },
        error: function () {
            $(".loadajax").hide();
            alert("error!!!!");
        },
    });
});

function loadRole(){
    $('.loadajax').show();
    $.ajax({
        url: "{{ route('admin.role.list') }}",
        type: "GET",
        dataType: "html",
        success: function (rsp) {
            $('.loadajax').hide();
            $('.card .card-body').html(rsp);
        },error: function () {
       alert("error!!!!");
        },
    });
}

    </script> --}}
    @endsection
