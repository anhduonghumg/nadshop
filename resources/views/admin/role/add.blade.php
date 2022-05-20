<div class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm quyền mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="fm_add_role">
                    <div class="form-group">
                        <label for="role_name" class="col-form-label">Tên quyền</label>
                        <input type="text" name="role_name" class="form-control" id="role_name"
                            placeholder="Nhập tên quyền">
                    </div>
                    <div class="form-group">
                        <label for="role_name" class="col-form-label">Permission</label>
                        <select id="role_permiss" name='role_permission[]' class="selectpicker form-control" multiple
                            data-live-search="true">
                            @if($list_permiss->isNotEmpty())
                            @foreach ($list_permiss as $item)
                            <option value="{{ $item->id }}">{{ $item->per_name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" id='save_role' class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>
