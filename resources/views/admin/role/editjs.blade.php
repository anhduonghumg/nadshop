<div class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sủa quyền</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="fm_update_role">
                    <div class="form-group">
                        <label for="role_name" class="col-form-label">Tên quyền</label>
                        <input type="text" name="role_name" class="form-control" id="role_name"
                            value="${role.role_name}">
                        <input type=" hidden" name="data_id" value="${role.id}">
                    </div>
                    <div class="form-group">
                        <label for="role_permiss" class="col-form-label">Permission</label>
                        <select id="role_permiss" name='role_permission[]' class="selectpicker form-control" multiple
                            data-live-search="true">
                            $.each(list_permiss, function (key, value) {
                            <option value="${value.id}">${value.per_name}</option>
                            })
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" id='update_role' class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>
