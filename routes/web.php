<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::group(['prefix' => 'laravel-filemanager', 'middleware'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Auth::routes(['verify' => true]);


// verified
Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/filter-by-date', [App\Http\Controllers\DashboardController::class, 'filter_by_date'])->name('dashboard.filter.date');
    Route::post('/filter', [App\Http\Controllers\DashboardController::class, 'filter'])->name('dashboard.filter');
    Route::post('/load-chart', [App\Http\Controllers\DashboardController::class, 'load_chart'])->name('load.chart');
    Route::post('/filter-month', [App\Http\Controllers\DashboardController::class, 'filter_month'])->name('load.chartMonth');
    Route::post('/filter-year', [App\Http\Controllers\DashboardController::class, 'filter_year'])->name('load.chartYear');
    Route::post('/export-excel-date', [App\Http\Controllers\DashboardController::class, 'export_date'])->name('dashboard.export.excel.date');
    Route::post('/export-excel-month', [App\Http\Controllers\DashboardController::class, 'export_month'])->name('dashboard.export.excel.month');
    Route::post('/export-excel-year', [App\Http\Controllers\DashboardController::class, 'export_year'])->name('dashboard.export.excel.year');
    // Admin/user
    Route::get('/admin/user/list', [App\Http\Controllers\AdminUserController::class, 'list'])->name('admin.user.list');
    Route::get('/admin/user/add', [App\Http\Controllers\AdminUserController::class, 'add'])->name('admin.user.add');
    Route::post('/admin/user/store', [App\Http\Controllers\AdminUserController::class, 'store'])->name('admin.user.store');
    Route::get('/admin/user/edit/{id}', [App\Http\Controllers\AdminUserController::class, 'edit'])->name('admin.user.edit');
    Route::post('/admin/user/update/{id}', [App\Http\Controllers\AdminUserController::class, 'update'])->name('admin.user.update');
    Route::get('/admin/user/delete/{id}', [App\Http\Controllers\AdminUserController::class, 'delete'])->name('admin.user.delete');
    Route::get('/admin/user/forceDelete/{id}', [App\Http\Controllers\AdminUserController::class, 'forceDelete'])->name('admin.user.forceDelete');
    Route::get('/admin/user/profile', [App\Http\Controllers\AdminUserController::class, 'profile'])->name('admin.user.profile');
    Route::post('/admin/user/profileUpdate/{id}', [App\Http\Controllers\AdminUserController::class, 'profileUpdate'])->name('admin.user.profileUpdate');
    Route::get('/admin/user/changePass', [App\Http\Controllers\AdminUserController::class, 'changePass'])->name('admin.user.changePass');
    Route::post('/admin/user/changePass/{id}', [App\Http\Controllers\AdminUserController::class, 'changePassUpdate'])->name('admin.user.changePassUpdate');
    Route::post('/admin/user/action', [App\Http\Controllers\AdminUserController::class, 'action'])->name('admin.user.action');

    // Admin/page
    Route::get('/admin/page/list', [App\Http\Controllers\AdminPageController::class, 'list'])->name('admin.page.list');
    Route::get('/admin/page/add', [App\Http\Controllers\AdminPageController::class, 'add'])->name('admin.page.add');
    Route::post('/admin/page/store', [App\Http\Controllers\AdminPageController::class, 'store'])->name('admin.page.store');
    Route::get('/admin/page/edit/{id}', [App\Http\Controllers\AdminPageController::class, 'edit'])->name('admin.page.edit');
    Route::post('/admin/page/update/{id}', [App\Http\Controllers\AdminPageController::class, 'update'])->name('admin.page.update');
    Route::get('/admin/page/delete/{id}', [App\Http\Controllers\AdminPageController::class, 'delete'])->name('admin.page.delete');
    Route::get('/admin/page/forceDelete/{id}', [App\Http\Controllers\AdminPageController::class, 'forceDelete'])->name('admin.page.forceDelete');
    Route::post('/admin/page/action', [App\Http\Controllers\AdminPageController::class, 'action'])->name('admin.page.action');

    // Admin/post/cat
    Route::get('/admin/post/cat/list', [App\Http\Controllers\AdminCategoryPostController::class, 'list'])->name('admin.catPost.list');
    Route::post('/admin/post/cat/add', [App\Http\Controllers\AdminCategoryPostController::class, 'add'])->name('admin.catPost.add');
    Route::get('/admin/post/cat/edit/{id}', [App\Http\Controllers\AdminCategoryPostController::class, 'edit'])->name('admin.catPost.edit');
    Route::post('/admin/post/cat/update/{id}', [App\Http\Controllers\AdminCategoryPostController::class, 'update'])->name('admin.catPost.update');
    Route::get('/admin/post/cat/delete/{id}', [App\Http\Controllers\AdminCategoryPostController::class, 'delete'])->name('admin.catPost.delete');
    Route::get('/admin/post/cat/forceDelete/{id}', [App\Http\Controllers\AdminCategoryPostController::class, 'forceDelete'])->name('admin.catPost.forceDelete');
    Route::post('/admin/post/cat/action', [App\Http\Controllers\AdminCategoryPostController::class, 'action'])->name('admin.catPost.action');

    // Admin/post
    Route::get('/admin/post/list', [App\Http\Controllers\AdminPostController::class, 'list'])->name('admin.post.list');
    Route::get('/admin/post/add', [App\Http\Controllers\AdminPostController::class, 'add'])->name('admin.post.add');
    Route::post('/admin/post/store', [App\Http\Controllers\AdminPostController::class, 'store'])->name('admin.post.store');
    Route::get('/admin/post/edit/{id}', [App\Http\Controllers\AdminPostController::class, 'edit'])->name('admin.post.edit');
    Route::post('/admin/post/update/{id}', [App\Http\Controllers\AdminPostController::class, 'update'])->name('admin.post.update');
    Route::get('/admin/post/delete/{id}', [App\Http\Controllers\AdminPostController::class, 'delete'])->name('admin.post.delete');
    Route::get('/admin/post/forceDelete/{id}', [App\Http\Controllers\AdminPostController::class, 'forceDelete'])->name('admin.post.forceDelete');
    Route::post('/admin/post/action', [App\Http\Controllers\AdminPostController::class, 'action'])->name('admin.post.action');

    // Admin/product/cat
    Route::get('/admin/product/cat/list', [App\Http\Controllers\AdminCategoryProductController::class, 'list'])->name('admin.catProduct.list');
    Route::post('/admin/product/cat/add', [App\Http\Controllers\AdminCategoryProductController::class, 'add'])->name('admin.catProduct.add');
    Route::get('/admin/product/cat/edit/{id}', [App\Http\Controllers\AdminCategoryProductController::class, 'edit'])->name('admin.catProduct.edit');
    Route::post('/admin/product/cat/update/{id}', [App\Http\Controllers\AdminCategoryProductController::class, 'update'])->name('admin.catProduct.update');
    Route::get('/admin/product/cat/delete/{id}', [App\Http\Controllers\AdminCategoryProductController::class, 'delete'])->name('admin.catProduct.delete');
    Route::get('/admin/product/cat/forceDelete/{id}', [App\Http\Controllers\AdminCategoryProductController::class, 'forceDelete'])->name('admin.catProduct.forceDelete');
    Route::post('/admin/product/cat/action', [App\Http\Controllers\AdminCategoryProductController::class, 'action'])->name('admin.catProduct.action');

    // Admin/product
    Route::get('/admin/product/list', [App\Http\Controllers\AdminProductController::class, 'list'])->name('admin.product.list');
    Route::get('/admin/product/add', [App\Http\Controllers\AdminProductController::class, 'add'])->name('admin.product.add');
    Route::post('/admin/product/store', [App\Http\Controllers\AdminProductController::class, 'store'])->name('admin.product.store');
    Route::get('/admin/product/edit/{id}', [App\Http\Controllers\AdminProductController::class, 'edit'])->name('admin.product.edit');
    Route::post('/admin/product/update/{id}', [App\Http\Controllers\AdminProductController::class, 'update'])->name('admin.product.update');
    Route::get('/admin/product/delete/{id}', [App\Http\Controllers\AdminProductController::class, 'delete'])->name('admin.product.delete');
    Route::get('/admin/product/forceDelete/{id}', [App\Http\Controllers\AdminProductController::class, 'forceDelete'])->name('admin.product.forceDelete');
    Route::post('/admin/product/action', [App\Http\Controllers\AdminProductController::class, 'action'])->name('admin.product.action');
    Route::get('/admin/product/list', [App\Http\Controllers\AdminProductController::class, 'list'])->name('admin.product.list');
    Route::get('/admin/product/variant', [App\Http\Controllers\AdminProductController::class, 'variant'])->name('admin.product.variant');
    Route::post('/admin/product/filter', [App\Http\Controllers\AdminProductController::class, 'filter'])->name('admin.product.filter');

    // Admin/product/detail
    Route::get('/admin/product/detail/show', [App\Http\Controllers\AdminProductDetailController::class, 'show'])->name('admin.product.detail.show');
    Route::get('/admin/product/detail/list', [App\Http\Controllers\AdminProductDetailController::class, 'list'])->name('admin.product.detail.list');
    Route::get('/admin/product/detail/edit', [App\Http\Controllers\AdminProductDetailController::class, 'edit'])->name('admin.product.detail.edit');
    Route::post('/admin/product/detail/update', [App\Http\Controllers\AdminProductDetailController::class, 'update'])->name('admin.product.detail.update');
    Route::get('/admin/product/detail/add', [App\Http\Controllers\AdminProductDetailController::class, 'add'])->name('admin.product.detail.add');
    Route::post('/admin/product/detail/store', [App\Http\Controllers\AdminProductDetailController::class, 'store'])->name('admin.product.detail.store');
    Route::post('/admin/product/detail/delete', [App\Http\Controllers\AdminProductDetailController::class, 'delete'])->name('admin.product.detail.delete');
    Route::get('/admin/product/detail/test', [App\Http\Controllers\AdminProductDetailController::class, 'test'])->name('admin.product.detail.test');
    Route::get('/admin/product/detail/addVariant', [App\Http\Controllers\AdminProductDetailController::class, 'addVariant'])->name('admin.product.detail.addVariant');
    Route::post('/admin/product/detail/storeVariant', [App\Http\Controllers\AdminProductDetailController::class, 'storeVariant'])->name('admin.product.detail.storeVariant');
    Route::get('/admin/product/stock', [App\Http\Controllers\AdminProductDetailController::class, 'stock'])->name('admin.product.stock');
    Route::post('/admin/product/stock/edit', [App\Http\Controllers\AdminProductDetailController::class, 'editStock'])->name('admin.product.edit.stock');
    Route::post('/admin/product/stock/update', [App\Http\Controllers\AdminProductDetailController::class, 'updateStock'])->name('admin.product.update.stock');
    // Admin/brand
    Route::get('/admin/brand/list', [App\Http\Controllers\AdminBrandController::class, 'list'])->name('admin.brand.list');
    Route::post('/admin/brand/add', [App\Http\Controllers\AdminBrandController::class, 'add'])->name('admin.brand.add');
    Route::get('/admin/brand/edit/{id}', [App\Http\Controllers\AdminBrandController::class, 'edit'])->name('admin.brand.edit');
    Route::post('/admin/brand/update/{id}', [App\Http\Controllers\AdminBrandController::class, 'update'])->name('admin.brand.update');
    Route::get('/admin/brand/delete/{id}', [App\Http\Controllers\AdminBrandController::class, 'delete'])->name('admin.brand.delete');
    Route::get('/admin/brand/forceDelete/{id}', [App\Http\Controllers\AdminBrandController::class, 'forceDelete'])->name('admin.brand.forceDelete');
    Route::post('/admin/brand/action', [App\Http\Controllers\AdminBrandController::class, 'action'])->name('admin.brand.action');

    // Admin/color
    Route::get('/admin/color/list', [App\Http\Controllers\AdminColorController::class, 'list'])->name('admin.color.list');
    Route::post('/admin/color/add', [App\Http\Controllers\AdminColorController::class, 'add'])->name('admin.color.add');
    Route::get('/admin/color/edit/{id}', [App\Http\Controllers\AdminColorController::class, 'edit'])->name('admin.color.edit');
    Route::post('/admin/color/update/{id}', [App\Http\Controllers\AdminColorController::class, 'update'])->name('admin.color.update');
    Route::get('/admin/color/delete/{id}', [App\Http\Controllers\AdminColorController::class, 'delete'])->name('admin.color.delete');
    // Route::get('/admin/brand/forceDelete/{id}', [App\Http\Controllers\AdminBrandController::class, 'forceDelete'])->name('admin.brand.forceDelete');
    Route::post('/admin/color/action', [App\Http\Controllers\AdminColorController::class, 'action'])->name('admin.color.action');

    // Admin/size
    Route::get('/admin/size/list', [App\Http\Controllers\AdminSizeController::class, 'list'])->name('admin.size.list');
    Route::post('/admin/size/add', [App\Http\Controllers\AdminSizeController::class, 'add'])->name('admin.size.add');
    Route::get('/admin/sỉze/edit/{id}', [App\Http\Controllers\AdminSizeController::class, 'edit'])->name('admin.size.edit');
    Route::post('/admin/size/update/{id}', [App\Http\Controllers\AdminSizeController::class, 'update'])->name('admin.size.update');
    Route::get('/admin/size/delete/{id}', [App\Http\Controllers\AdminSizeController::class, 'delete'])->name('admin.size.delete');
    // Route::get('/admin/size/forceDelete/{id}', [App\Http\Controllers\AdminBrandController::class, 'forceDelete'])->name('admin.color.forceDelete');
    Route::post('/admin/size/action', [App\Http\Controllers\AdminSizeController::class, 'action'])->name('admin.size.action');

    Route::get('/admin/coupon/list', [App\Http\Controllers\AdminCouponController::class, 'list'])->name('admin.coupon.list');
    Route::post('/admin/coupon/add', [App\Http\Controllers\AdminCouponController::class, 'add'])->name('admin.coupon.add');
    Route::get('/admin/coupon/edit/{id}', [App\Http\Controllers\AdminCouponController::class, 'edit'])->name('admin.coupon.edit');
    Route::post('/admin/coupon/update/{id}', [App\Http\Controllers\AdminCouponController::class, 'update'])->name('admin.coupon.update');
    Route::get('/admin/coupon/delete/{id}', [App\Http\Controllers\AdminCouponController::class, 'delete'])->name('admin.coupon.delete');
    // Route::get('/admin/size/forceDelete/{id}', [App\Http\Controllers\AdminBrandController::class, 'forceDelete'])->name('admin.color.forceDelete');
    Route::post('/admin/coupon/action', [App\Http\Controllers\AdminCouponController::class, 'action'])->name('admin.coupon.action');

    Route::get('/admin/slider/list', [App\Http\Controllers\AdminSliderController::class, 'list'])->name('admin.slider.list');
    Route::post('/admin/slider/add', [App\Http\Controllers\AdminSliderController::class, 'add'])->name('admin.slider.add');
    Route::get('/admin/slider/edit/{id}', [App\Http\Controllers\AdminSliderController::class, 'edit'])->name('admin.slider.edit');
    Route::post('/admin/slider/update/{id}', [App\Http\Controllers\AdminSliderController::class, 'update'])->name('admin.slider.update');
    Route::get('/admin/slider/delete/{id}', [App\Http\Controllers\AdminSliderController::class, 'delete'])->name('admin.slider.delete');
    // Route::get('/admin/brand/forceDelete/{id}', [App\Http\Controllers\AdminBrandController::class, 'forceDelete'])->name('admin.brand.forceDelete');
    Route::post('/admin/slider/action', [App\Http\Controllers\AdminSliderController::class, 'action'])->name('admin.slider.action');

    // Admin/order
    Route::get('/admin/order/list', [App\Http\Controllers\AdminOrderController::class, 'list'])->name('admin.order.list');
    Route::get('/admin/order/add', [App\Http\Controllers\AdminOrderController::class, 'add'])->name('admin.order.add');
    Route::get('/admin/order/loadDistrict', [App\Http\Controllers\AdminOrderController::class, 'loadDistrict'])->name('admin.order.district');
    Route::get('/admin/order/addProduct', [App\Http\Controllers\AdminOrderController::class, 'addProduct'])->name('admin.order.addProduct');
    Route::post('/admin/order/store', [App\Http\Controllers\AdminOrderController::class, 'store'])->name('admin.order.store');
    Route::get('/admin/order/detail', [App\Http\Controllers\AdminOrderController::class, 'detail'])->name('admin.order.detail');
    Route::post('/admin/order/update', [App\Http\Controllers\AdminOrderController::class, 'update'])->name('admin.order.update');
    Route::get('/admin/order/edit/{id}', [App\Http\Controllers\AdminOrderController::class, 'edit'])->name('admin.order.edit');
    Route::post('/admin/order/delete', [App\Http\Controllers\AdminOrderController::class, 'delete'])->name('admin.order.delete');
    Route::post('/admin/order/action', [App\Http\Controllers\AdminOrderController::class, 'action'])->name('admin.order.action');
    Route::get('/admin/order/print_order/{id}', [App\Http\Controllers\AdminOrderController::class, 'print_order'])->name('admin.order.print_order');

    // Admin/customer
    Route::get('/admin/customer/list', [App\Http\Controllers\AdminCustomerController::class, 'list'])->name('admin.customer.list');
    Route::get('/admin/customer/export', [App\Http\Controllers\AdminCustomerController::class, 'export'])->name('admin.customer.export');
    Route::get('/admin/customer/sendCoupon', [App\Http\Controllers\AdminCustomerController::class, 'sendCoupon'])->name('admin.customer.sendCoupon');
    // Admin/role
    Route::get('/admin/role/list', [App\Http\Controllers\AdminRoleController::class, 'list'])->name('admin.role.list');
    Route::get('/admin/role/add', [App\Http\Controllers\AdminRoleController::class, 'add'])->name('admin.role.add');
    Route::post('/admin/role/store', [App\Http\Controllers\AdminRoleController::class, 'store'])->name('admin.role.store');
    Route::get('/admin/role/edit', [App\Http\Controllers\AdminRoleController::class, 'edit'])->name('admin.role.edit');
    Route::post('/admin/role/update', [App\Http\Controllers\AdminRoleController::class, 'update'])->name('admin.role.update');
    Route::post('/admin/role/delete', [App\Http\Controllers\AdminRoleController::class, 'delete'])->name('admin.role.delete');

    // Admin/permission
    Route::get('/admin/permission/list', [App\Http\Controllers\AdminPermissionController::class, 'list'])->name('admin.permission.list');
    Route::get('/admin/permission/add', [App\Http\Controllers\AdminPermissionController::class, 'add'])->name('admin.permission.add');
    Route::post('/admin/permission/store', [App\Http\Controllers\AdminPermissionController::class, 'store'])->name('admin.permission.store');
    Route::get('/admin/permission/edit', [App\Http\Controllers\AdminPermissionController::class, 'edit'])->name('admin.permission.edit');
    Route::post('/admin/permission/update', [App\Http\Controllers\AdminPermissionController::class, 'update'])->name('admin.permission.update');
    Route::post('/admin/permission/delete', [App\Http\Controllers\AdminPermissionController::class, 'delete'])->name('admin.permission.delete');

    // Admin/comment
    Route::get('/admin/comment/list', [App\Http\Controllers\AdminCommentController::class, 'show'])->name('admin.comment.list');
    Route::post('/admin/comment/approve', [App\Http\Controllers\AdminCommentController::class, 'approve'])->name('admin.approveComment');
    Route::post('/admin/comment/reply', [App\Http\Controllers\AdminCommentController::class, 'reply'])->name('admin.replyComment');
    Route::post('/admin/comment/delete', [App\Http\Controllers\AdminCommentController::class, 'delete'])->name('admin.comment.delete');
    // Export excel
    Route::post('/admin/product/export-csv', [App\Http\Controllers\AdminProductController::class, 'export'])->name('admin.product.export');
    // Route::post('/import-csv', 'ProductController@import_csv');

    // Route::get('/chart', [App\Http\Controllers\TestController::class, 'chart'])->name('chart');
    // Route::post('/filter-by-date', [App\Http\Controllers\TestController::class, 'filter_by_date'])->name('filter');

    // helper
    Route::get('/admin/collection/test', [App\Http\Controllers\AdminCollectionTestController::class, 'test'])->name('admin.collection.test');
    Route::get('/admin/helper/array', [App\Http\Controllers\AdminHelperController::class, 'array'])->name('admin.helper.array');
    Route::get('/admin/helper/string', [App\Http\Controllers\AdminHelperController::class, 'string'])->name('admin.helper.string');
    Route::get('/admin/helper/path', [App\Http\Controllers\AdminHelperController::class, 'path'])->name('admin.helper.path');
    Route::get('/admin/helper/miscellaneous', [App\Http\Controllers\AdminHelperController::class, 'miscellaneous'])->name('admin.helper.miscellaneous');

    // upload file
    // Route::get('/admin/file/view', [App\Http\Controllers\AdminFileController::class, 'view'])->name('admin.file.view');
    // Route::post('/admin/file/upload', [App\Http\Controllers\AdminFileController::class, 'upload'])->name('admin.file.upload');
    // Route::get('/admin/file/multiple', [App\Http\Controllers\AdminFileController::class, 'multiple'])->name('admin.file.multiple');
    // Route::post('/admin/file/multipleUpload', [App\Http\Controllers\AdminFileController::class, 'multipleUpload'])->name('admin.file.multipleUpload');

    // resize image
    // Route::get('/image/resize',  [App\Http\Controllers\ImageController::class, 'resize'])->name('image.resize');
    // Route::get('/{imagePath}/{size}', [App\Http\Controllers\ImageController::class, 'flyResize'])->where('imagePath', '(.*)');
    // Route::get('/image/upload',  [App\Http\Controllers\ImageController::class, 'upload'])->name('image.upload');

    // city district
    // Route::get('/test', [App\Http\Controllers\TestController::class, 'paginatejs'])->name('test');
});

// CLIENT

Route::middleware('isLogin')->group(function () {
    Route::get('profile', [App\Http\Controllers\Client\UserController::class, 'profile'])->name('client.profile');
    Route::get('profile/edit', [App\Http\Controllers\Client\UserController::class, 'profileEdit'])->name('client.profileEdit');
    Route::post('profile/update', [App\Http\Controllers\Client\UserController::class, 'profileUpdate'])->name('client.customerUpdateInfo');
    Route::get('profile/changePass', [App\Http\Controllers\Client\UserController::class, 'profileChangePass'])->name('client.changePass');
    Route::post('changePass', [App\Http\Controllers\Client\UserController::class, 'changePass'])->name('client.updatePass');
    Route::get('profile/order/history', [App\Http\Controllers\Client\UserController::class, 'orderHistory'])->name('client.orderHistory');
    Route::post('profile/order/detail', [App\Http\Controllers\Client\UserController::class, 'orderDetail'])->name('client.orderDetail');
    Route::post('profile/order/cancel', [App\Http\Controllers\Client\UserController::class, 'orderCancel'])->name('client.orderCancel');
    Route::post('profile/order/cancelConfirm', [App\Http\Controllers\Client\UserController::class, 'orderCancelConfirm'])->name('client.orderCancelConfirm');
});

Route::get('user/signin', [App\Http\Controllers\Client\UserController::class, 'login']);
Route::get('user/signup', [App\Http\Controllers\Client\UserController::class, 'register']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('client.home');
Route::get('product/cat/{id}', [App\Http\Controllers\Client\ProductCategoryController::class, 'show'])->name('client.product.cat.show');
Route::get('product/{id}', [App\Http\Controllers\Client\ProductController::class, 'detail'])->name('client.product.detail');
Route::post('product/filter', [App\Http\Controllers\Client\ProductController::class, 'filter'])->name('client.product.filter');
Route::post('product/variant', [App\Http\Controllers\Client\ProductController::class, 'variant'])->name('client.product.variant');
Route::post('product/change', [App\Http\Controllers\Client\ProductController::class, 'change'])->name('client.product.change');
Route::post('load_product', [App\Http\Controllers\Client\ProductController::class, 'load_product'])->name('client.product.load');
Route::get('wishlist', [App\Http\Controllers\Client\ProductController::class, 'wishlist'])->name('client.product.wishlist');
Route::post('load_product', [App\Http\Controllers\Client\ProductController::class, 'load_product'])->name('client.product.load');
Route::post('product/comment', [App\Http\Controllers\Client\ProductController::class, 'show_comment'])->name('client.product.comment');
Route::post('product/comment/add', [App\Http\Controllers\Client\ProductController::class, 'add_comment'])->name('client.addComment');
Route::get('product/comment/load', [App\Http\Controllers\Client\ProductController::class, 'load_comment'])->name('client.loadComment');
Route::post('product/rating', [App\Http\Controllers\Client\ProductController::class, 'rating'])->name('client.insertRating');

// Rank
Route::post('product/rank', [App\Http\Controllers\Client\ProductController::class, 'rank'])->name('client.product.rank');
Route::post('product/rankTopview', [App\Http\Controllers\Client\ProductController::class, 'rankTopView'])->name('client.product.rankTopView');

// CART
Route::post('cart/add', [App\Http\Controllers\Client\CartController::class, 'add'])->name('client.cart.add');
Route::post('cart/buy_now', [App\Http\Controllers\Client\CartController::class, 'buy_now'])->name('client.cart.buy_now');
Route::get('cart/show', [App\Http\Controllers\Client\CartController::class, 'show'])->name('client.cart.show');
Route::post('cart/buy', [App\Http\Controllers\Client\CartController::class, 'buy'])->name('client.cart.buy');
Route::get('cart/checkout', [App\Http\Controllers\Client\CartController::class, 'checkout'])->name('client.cart.checkout');
Route::post('cart/order', [App\Http\Controllers\Client\CartController::class, 'order'])->name('client.cart.order');
Route::get('thank/{code}', [App\Http\Controllers\Client\CartController::class, 'thank'])->name('client.thank');
Route::post('cart/changePayment', [App\Http\Controllers\Client\CartController::class, 'changePayment'])->name('client.change.payment');
Route::post('vnpay_payment', [App\Http\Controllers\Client\CartController::class, 'vnpayPayment'])->name('vnpay_payment');
Route::get('cart/checkvnpay', [App\Http\Controllers\Client\CartController::class, 'checkVnpay'])->name('check_vnpay');
Route::post('confirm_vnpay', [App\Http\Controllers\Client\CartController::class, 'confirmVnpay'])->name('confirm_vnpay');
Route::post('cart/checkqty', [App\Http\Controllers\Client\CartController::class, 'checkQty'])->name('client.cart.checkQty');
Route::post('cart/discount', [App\Http\Controllers\Client\CartController::class, 'discount'])->name('client.cart.discount');
Route::post('cart/point', [App\Http\Controllers\Client\CartController::class, 'point'])->name('client.cart.point');
// Route::get('', [App\Http\Controllers\Client\CartController::class, 'thank'])->name('client.thank');
// Route::get('thank/{code}', [App\Http\Controllers\Client\CartController::class, 'thank'])->name('client.thank');
// ORDER
Route::get('order/find', [App\Http\Controllers\Client\OrderController::class, 'find'])->name('client.order.find');
Route::post('order/show', [App\Http\Controllers\Client\OrderController::class, 'show'])->name('client.order.show');
Route::post('order/detail', [App\Http\Controllers\Client\OrderController::class, 'detail'])->name('client.order.detail');
Route::post('order/cancel', [App\Http\Controllers\Client\OrderController::class, 'cancel'])->name('client.order.cancel');
Route::post('order/confirm', [App\Http\Controllers\Client\OrderController::class, 'confirm'])->name('client.order.confirm');
// City_District
Route::post('district', [App\Http\Controllers\Client\DistrictController::class, 'show'])->name('client.district');

// Search
Route::get('search', [App\Http\Controllers\Client\SearchController::class, 'show'])->name('client.search');
Route::post('searchAjax', [App\Http\Controllers\Client\SearchController::class, 'searchAjax'])->name('client.ajax');
Route::post('searchAuto', [App\Http\Controllers\Client\SearchController::class, 'searchAutoCompalte'])->name('client.searchAuto');
// Login
Route::post('userRegister', [App\Http\Controllers\Client\UserController::class, 'register'])->name('client.register');
Route::post('userLogin', [App\Http\Controllers\Client\UserController::class, 'login'])->name('client.login');
Route::get('userLogout', [App\Http\Controllers\Client\UserController::class, 'logout'])->name('client.logout');
Route::post('userForgotPass', [App\Http\Controllers\Client\UserController::class, 'forgotPass'])->name('client.forgotPass');

// NEWS
Route::get('news', [App\Http\Controllers\Client\PostController::class, 'show'])->name('client.news');
Route::get('new/{id}', [App\Http\Controllers\Client\PostController::class, 'detail'])->name('client.new.detail');
