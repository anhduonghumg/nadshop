<div class="form-action form-inline py-3">
    <select class="form-control mr-1" name="act" id="act">
        <option value="">Chọn</option>
    </select>
    <input type="button" name="btn_action" value="Áp dụng" class="btn btn-primary mr-3">
    <button class="btn btn-success btn-rounded add_role"><i class="fa fa-plus"></i> Thêm
        mới</button>
</div>
<div class="table-responsive">
    @if($list_roles->isNotEmpty())
    <table class="table table-striped custom-table">
        <thead>
            <tr>
                <th>Hành động được phép</th>
                @foreach ($list_permissions as $permission)
                <th class="text-center">{{ $permission->per_name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($list_roles as $role)
            <tr>
                <td class="d-flex justify-content-between" width="50%">
                    <strong>{{ $role->role_name }}</strong>
                    <section class='ml-3'>
                        <a href="" class="role-edit" data-id={{ $role->id }}>sửa</a>
                        <a href="" class="role-delete" data-id={{ $role->id }}>xóa</a>
                    </section>
                </td>
                @foreach ($list_permissions as $permission)
                <td class="text-center">
                    <input type="checkbox" name="list_check"
                        @if(in_array($permission->id,get_selected($role->id)->pluck('per_id')->toArray())) checked
                    @endif />
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
{{ $list_roles->links('layouts.paginationlink') }}
