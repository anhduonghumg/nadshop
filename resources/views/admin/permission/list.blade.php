@extends('layouts.admin')
@section('title','Permission')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5>Permission</h5>
        </div>
        <div class="card-body">
            <div class="form-action form-inline py-3">
                {{-- <select class="form-control mr-1" name="act" id="act">
                    <option value="">Chọn</option>
                </select>
                <input type="button" name="btn_action" value="Áp dụng" class="btn btn-primary mr-3"> --}}
                <button class="btn btn-success btn-rounded add_permission"><i class="fa fa-plus"></i> Thêm
                    mới</button>
            </div>
            {{-- <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">
                            <input id="checkall" name="checkall" type="checkbox">
                        </th>
                        <th scope="col">STT</th>
                        <th scope="col">Permission</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                @if($list_permissions->isNotEmpty())
                @php $temp = 0; @endphp
                <tbody>
                    @foreach ($list_permissions as $permission)
                    @php $temp++ @endphp
                    <tr>
                        <th scope="col">
                            <input id="checkall" name="checkall" type="checkbox">
                        </th>
                        <td scope="col">{{ $temp }}</td>
                        <td scope="col">{{ $permission->per_name }}</td>
                        <td>
                            <a class="btn btn-success btn-sm rounded-0 text-white edit-permiss" type="button"
                                data-toggle="tooltip" data-placement="top" title="Edit"
                                data-id="{{ $permission->id }}"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-danger btn-sm rounded-0 text-white delete-permiss" type="button"
                                data-toggle="tooltip" data-placement="top" title="Delete"
                                data-id="{{ $permission->id }}"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @else
                <tr>
                    <td colspan='4' class="bg-white">
                        <p>Không có bản ghi nào.</p>
                    </td>
                </tr>
                @endif
            </table> --}}
            {{-- {{ $list_roles->links('layouts.paginationlink') }} --}}
        </div>
    </div>
</div>
<div id="modalPopup">
</div>
<script type="text/javascript">
    loadPermiss();
    $(document).on('click','.add_permission',function(){
        $('.loadajax').show();
        $.ajax({
            url: "{{ route('admin.permission.add') }}",
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

$(document).on('click','#save_permiss',function(){
    var data = $('#fm_add_permission').serializeArray();
    $('.loadajax').show();
    $.ajax({
        url: "{{ route('admin.permission.store') }}",
        type: "POST",
        data: data,
        dataType: "json",
        success: function (rsp) {
            $('.loadajax').hide();
            if ($.isEmptyObject(rsp.errors)) {
                confirm_success(rsp.success);
                $('.modal').modal('hide');
                loadPermiss();
            } else {
                confirm_warning(rsp.errors);
            }
        },error: function () {
            alert("error!!!!");
        },
    });
});

$(document).on('click','.edit-permission',function(){
    $('.loadajax').show();
    var id = $(this).data('id');
    $.ajax({
        url: "{{ route('admin.permission.edit') }}",
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

$(document).on('click','#update_permiss',function(){
    var data = $('#fm_update_permission').serializeArray();
    $('.loadajax').show();
    $.ajax({
        url: "{{ route('admin.permission.update') }}",
        type: "POST",
        data: data,
        dataType: "json",
        success: function (rsp) {
            $('.loadajax').hide();
            if ($.isEmptyObject(rsp.errors)) {
                confirm_success(rsp.success);
                $('.modal').modal('hide');
                loadPermiss();
            } else {
                confirm_warning(rsp.errors);
            }
        },error: function () {
            alert("error!!!!");
        },
    });
});

$(document).on('click','.delete-permission',function(){
    var id = $(this).attr("data-id");
    $.ajax({
        url: "{{ route('admin.permission.delete') }}",
        type: "POST",
        dataType: "json",
        data: {id:id},
        beforeSend:function(){
           return confirm("Bạn thực sự muốn xóa?");
         },
        success: function (rsp) {
            $(".loadajax").hide();
            confirm_success(rsp.success);
            loadPermiss();
        },
        error: function () {
            $(".loadajax").hide();
            alert("error!!!!");
        },
    });
});

function loadPermiss(){
    $('.loadajax').show();
    $.ajax({
        url: "{{ route('admin.permission.list') }}",
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

</script>
@endsection
