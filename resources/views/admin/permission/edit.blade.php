<div class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sủa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="fm_update_permission">
                    <div class="form-group">
                        <label for="per_name" class="col-form-label">Tên</label>
                        <input type="text" name="per_name" class="form-control" id="per_name" value="{{
                            $permission->per_name }}">
                        <input type="hidden" name="data_id" value="{{ $permission->id }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" id='update_permiss' class="btn btn-primary">Lưu</button>
            </div>
        </div>
    </div>
</div>
