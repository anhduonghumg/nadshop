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
                <label for="note_cancel">Lí do hủy <span style="color:red">*</span>:</label>
                <textarea class="form-control" name="note" id="note_cancel" cols="30" rows="5"></textarea>
                <input type="hidden" class="id_order" value="{{ $id }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn_confirm_cancel">Xác nhận</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).on('click', '.btn_confirm_cancel', function() {
        let id = $('.id_order').val();
        let note = $('#note_cancel').val();
        $.ajax({
            url: "{{ route('client.orderCancelConfirm') }}",
            data: {
                id: id,
                note: note
            },
            type: "POST",
            dataType: "json",
            success: function(rsp) {
                if ($.isEmptyObject(rsp.errors)) {
                    confirm_success(rsp.success);
                    location.reload();
                } else {
                    confirm_warning(rsp.errors);
                }
            },
            error: function() {
                //$(".loadajax").hide();
                alert("error!!!!");
            },
        });
    })
</script>
