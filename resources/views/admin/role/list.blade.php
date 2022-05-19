@extends('layouts.admin')
@section('title', 'Danh sách bài viết')
@section('content')
<!-- Page Content -->
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header mt-3 mb-3">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Quản lý quyền</h3>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-3">
            <button class="btn btn-danger btn-sm btn-block"><i class="fa fa-plus"></i> Add Roles</button>
            <div class="roles-menu">
                <ul>
                    {{-- @foreach ($rolesPermissions as $rolesName ) --}}
                    <li class="">
                        <span hidden class="id"></span>
                        <a class="active" href="javascript:void(0);"><span class="role_name">Admin</span>
                            <span class="role-action">
                                <span class="action-circle large rolesUpdate" data-id="">
                                    <i class="material-icons">edit</i>
                                </span>
                                <span class="action-circle large delete-btn rolesDelete" data-id="">
                                    <i class="material-icons">delete</i>
                                </span>
                            </span>
                        </a>
                    </li>
                    <li class="">
                        <span hidden class="id"></span>
                        <a class="active" href="javascript:void(0);"><span class="role_name">CTV</span>
                            <span class="role-action">
                                <span class="action-circle large rolesUpdate" data-id="">
                                    <i class="material-icons">edit</i>
                                </span>
                                <span class="action-circle large delete-btn rolesDelete" data-id="">
                                    <i class="material-icons">delete</i>
                                </span>
                            </span>
                        </a>
                    </li>
                    {{-- @endforeachFF --}}
                </ul>
            </div>
        </div>
        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-9">
            <h6 class="card-title m-b-20">Module được truy cập</h6>
            <div class="m-b-30">
                <ul class="list-group notification-list">
                    <li class="list-group-item d-flex justify-content-between">
                        <label>Quản lý người dùng</label>
                        <div class="status-toggle">
                            <input type="checkbox" id="staff_module" class="check">
                            <label for="staff_module" class="checktoggle">checkbox</label>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <label>Quản lý trang</label>
                        <div class="status-toggle">
                            <input type="checkbox" id="staff_module" class="check">
                            <label for="staff_module" class="checktoggle">checkbox</label>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <label>Quản lý bài viết</label>
                        <div class="status-toggle">
                            <input type="checkbox" id="staff_module" class="check">
                            <label for="staff_module" class="checktoggle">checkbox</label>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <label>Quản lý sản phẩm</label>
                        <div class="status-toggle">
                            <input type="checkbox" id="staff_module" class="check">
                            <label for="staff_module" class="checktoggle">checkbox</label>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <label>Quản lý bán hàng</label>
                        <div class="status-toggle">
                            <input type="checkbox" id="staff_module" class="check">
                            <label for="staff_module" class="checktoggle">checkbox</label>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="table-responsive">
                <table class="table table-striped custom-table">
                    <thead>
                        <tr>
                            <th>Hành động được phép</th>
                            <th class="text-center">Thêm</th>
                            <th class="text-center">Sửa</th>
                            <th class="text-center">Xóa</th>
                            <th class="text-center">Xem</th>
                            <th class="text-center">Xuất</th>
                            <th class="text-center">Nhập</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Employee</td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                        </tr>
                        <tr>
                            <td>Holidays</td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                        </tr>
                        <tr>
                            <td>Leaves</td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                        </tr>
                        <tr>
                            <td>Events</td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" checked="">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->

</div>
{{-- modal add product detail --}}
<div id="modalPopup">
</div>
@endsection
