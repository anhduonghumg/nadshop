@extends ('layouts.admin')
@section('title', 'Danh sách sản phẩm sắp hết')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5>Danh sách sản phẩm sắp hết</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped product_run_out">
                    <thead>
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá bán</th>
                            <th scope="col">Giảm giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $temp = 0 @endphp
                        @foreach ($list_product_run_out as $item)
                            @php $temp++ @endphp
                            <tr>
                                <th scope="row">{{ $temp }}</th>
                                <td>
                                    <img src="{{ asset('storage/app/public/images/product/thumb') . '/' . $item->product_details_thumb }}"
                                        width="80px" height="80px" alt="" />
                                </td>
                                <td>{{ $item->product_detail_name }}</td>
                                <td>{{ currentcyFormat($item->product_price) }}</td>
                                <td>{{ $item->product_discount }}%</td>
                                <td>{{ $item->product_qty_stock }}</td>
                                <td>
                                    <a class="btn btn-success btn-sm rounded-0 text-white edit-stock" type="button"
                                        data-id="{{ $item->id }}" data-placement="top" title="Sửa"><i
                                            class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="modalPopupEdit"></div>
    <script type="text/javascript">
        $(".product_run_out").DataTable({
            pageLength: 20,
            lengthChange: false,
            drawCallback: function(settings) {
                if ($(this).find('tbody tr').length < 20) {
                    $('.dataTables_paginate').hide();
                }
            }
        });
    </script>
    <script>
        $(document).on('click', '.edit-stock', function() {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('admin.product.edit.stock') }}",
                type: "POST",
                data: {
                    id: id,
                },
                success: function(data) {
                    $('#modalPopupEdit').html(data);
                    $('.edit-stock-modal').modal('show');
                }
            });
        })
    </script>
@endsection
