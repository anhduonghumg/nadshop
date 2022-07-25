<form>
    <div class="modal" id="modal_cancel" data-backdrop="static" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận hủy đơn hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="note">Lí do hủy <span style="color:red">*</span>:</label>
                    <textarea class="form-control" name="note" id="note" cols="30" rows="5"></textarea>
                    <input type="hidden" id="order_id" value="{{ $id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary confirm_cancel">Xác nhận</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>
</form>
