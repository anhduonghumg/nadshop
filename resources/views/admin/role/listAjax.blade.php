<div class="form-action form-inline py-3">
    <select class="form-control mr-1" name="act" id="act">
        <option value="">Chọn</option>
    </select>
    <input type="button" name="btn_action" value="Áp dụng" class="btn btn-primary mr-3">
    <button class="btn btn-success btn-rounded add_role"><i class="fa fa-plus"></i> Thêm
        mới</button>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">
                <input id="checkall" name="checkall" type="checkbox">
            </th>
            <th scope="col">STT</th>
            <th scope="col">Tên quyền</th>
            <th scope="col">Tác vụ</th>
        </tr>
    </thead>
    @if($list_roles->isNotEmpty())
    @php $temp = 0; @endphp
    <tbody>
        @foreach ($list_roles as $role)
        @php $temp++ @endphp
        <tr>
            <th scope="col">
                <input id="checkall" name="checkall" type="checkbox">
            </th>
            <td scope="col">{{ $temp }}</td>
            <td scope="col">{{ $role->role_name }}</td>
            <td>
                <a class="btn btn-success btn-sm rounded-0 text-white edit-role" type="button" data-toggle="tooltip"
                    data-placement="top" title="Edit" data-id="{{ $role->id }}"><i class="fa fa-edit"></i></a>
                <a class="btn btn-danger btn-sm rounded-0 text-white delete-role" type="button" data-toggle="tooltip"
                    data-placement="top" title="Delete" data-id="{{ $role->id }}"><i class="fa fa-trash"></i></a>
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
</table>
{{ $list_roles->links('layouts.paginationlink') }}
