<?php

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
Route::get('/lang', [App\Http\Controllers\fashi\UsersController::class, 'LangChange'])->name('LangChange');


// front end pages
Route::get('/', [App\Http\Controllers\fashi\UsersController::class, 'index'])->name('Jeevan.index');
Route::get('/lang/{lang_code?}', [App\Http\Controllers\fashi\UsersController::class, 'updateLanguage'])->name('Jeevan.updateLanguage');

Route::get('jeevan-about-us', [App\Http\Controllers\fashi\UsersController::class, 'aboutUs'])->name('Jeevan.aboutUs');
Route::get('jeevan-shop', [App\Http\Controllers\fashi\UsersController::class, 'shop'])->name('Jeevan.shop');

Route::get('add-to-cart/{id}', [App\Http\Controllers\fashi\UsersController::class, 'addToCart'])->name('Jeevan.addToCart');
Route::get('shopping', [App\Http\Controllers\fashi\UsersController::class, 'shoppingCart'])->name('Jeevan.shoppingCart');
Route::get('shopping/delete/{id}', [App\Http\Controllers\fashi\UsersController::class, 'removeCartItem'])->name('Jeevan.removeCartItem');

Route::get('checkout', [App\Http\Controllers\fashi\UsersController::class, 'checkout'])->name('Jeevan.checkout');
Route::get('jeevan-payment', [App\Http\Controllers\fashi\UsersController::class, 'stripe'])->name('stripe.payment');
Route::get('jeevan-order', [App\Http\Controllers\fashi\UsersController::class, 'order'])->name('Jeevan.order');

Route::get('jeevan-product-faq', [App\Http\Controllers\fashi\UsersController::class, 'faq'])->name('Jeevan.faq');
Route::get('jeevan-product-listing', [App\Http\Controllers\fashi\UsersController::class, 'productListing'])->name('Jeevan.productListing');

Route::get('jeevan-product-detail/{id}', [App\Http\Controllers\fashi\UsersController::class, 'productDetail'])->name('Jeevan.productDetail');

Route::get('jeevan-blog-listing', [App\Http\Controllers\fashi\UsersController::class, 'blogListing'])->name('Jeevan.blogListing');
Route::get('jeevan-blog-detail/{id?}', [App\Http\Controllers\fashi\UsersController::class, 'blogDetail'])->name('Jeevan.blogDetail');

Route::get('jeevan-contact-us', [App\Http\Controllers\fashi\UsersController::class, 'contact'])->name('Jeevan.contact');
Route::get('jeevan-contact-us/{id}', [App\Http\Controllers\fashi\UsersController::class, 'contact_us'])->name('Jeevan.contactDetail');
Route::post('jeevan-contact-enquiry', [App\Http\Controllers\fashi\UsersController::class, 'contactEnquiry'])->name('Jeevan.contactEnquiry');

Route::get('jeevan-404', [App\Http\Controllers\fashi\UsersController::class, 'pageNotFound'])->name('Jeevan.pageNotFound');

  Route::match(['get', 'post'], '/otp/{validate_string?}',[App\Http\Controllers\fashi\UserLoginController::class, 'userLoginOtp'])->name('UserLoginOtp');
Route::match(['get', 'post'], '/login',[App\Http\Controllers\fashi\UserLoginController::class, 'login'])->name('UserLogin');
Route::match(['get', 'post'], '/login-otp',[App\Http\Controllers\fashi\UserLoginController::class, 'verifyOtp'])->name('verifyOtp');
Route::match(['get', 'post'], '/signup',[App\Http\Controllers\fashi\UserLoginController::class, 'signup'])->name('UserSignup');

Route::match(['get', 'post'], '/reset-password',[App\Http\Controllers\fashi\UserLoginController::class, 'changePassword'])->name('UserChangePassword');
Route::match(['get', 'post'], '/forget-password',[App\Http\Controllers\fashi\UserLoginController::class, 'forgetPassword'])->name('UserForgetPassword');
Route::get('/logout', [App\Http\Controllers\fashi\UserLoginController::class, 'logout'])->name('UserLogout');



Route::group(['prefix' => 'adminpnlx'], function () {

Route::get('/',[App\Http\Controllers\adminpnlx\AdminController::class, 'login'])->name('Admin.login');
Route::post('/',[App\Http\Controllers\adminpnlx\AdminController::class, 'login'])->name('Admin.login')->middleware("throttle:3,1");
Route::get('/logout', [App\Http\Controllers\adminpnlx\AdminController::class, 'logout'])->name('Admin.logout');
Route::get('/forget-password',[App\Http\Controllers\adminpnlx\AdminController::class, 'forgetPassword'])->name('Admin.forgetPassword');
Route::post('/forget-password',[App\Http\Controllers\adminpnlx\AdminController::class, 'forgetPassword'])->name('Admin.forgetPassword');


Route::group(['middleware' => 'admin'], function () {
Route::get('/dashboard', [App\Http\Controllers\adminpnlx\DashboardController::class, 'index'])->name('dashboard');
Route::get('/change-password',[App\Http\Controllers\adminpnlx\DashboardController::class, 'changePassword'])->name('Admin.changePassword');
Route::post('/change-password',[App\Http\Controllers\adminpnlx\DashboardController::class, 'changePassword'])->name('Admin.changePassword');
Route::post('/my-account',[App\Http\Controllers\adminpnlx\DashboardController::class, 'myAccount'])->name('myAccount');
Route::get('/my-account',[App\Http\Controllers\adminpnlx\DashboardController::class, 'myAccount'])->name('myAccount');

// acls
Route::get('/acl', [App\Http\Controllers\adminpnlx\AclController::class, 'index'])->name('Acl.index');
Route::get('/acl/create', [App\Http\Controllers\adminpnlx\AclController::class, 'create'])->name('Acl.create');
Route::post('/acl/store', [App\Http\Controllers\adminpnlx\AclController::class, 'store'])->name('Acl.store');
Route::get('/acl/edit/{id}', [App\Http\Controllers\adminpnlx\AclController::class, 'edit'])->name('Acl.edit');
Route::post('/acl/update/{id}', [App\Http\Controllers\adminpnlx\AclController::class, 'update'])->name('Acl.update');
Route::get('/acl/delete/{id}', [App\Http\Controllers\adminpnlx\AclController::class, 'delete'])->name('Acl.delete');
Route::get('/acl/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\AclController::class, 'changeStatus'])->name('Acl.changeStatus');


// Coustomers
Route::get('/users', [App\Http\Controllers\adminpnlx\UserController::class, 'index'])->name('User.index');
Route::get('/users/view/{id}', [App\Http\Controllers\adminpnlx\UserController::class, 'show'])->name('User.show');
Route::get('/users/create', [App\Http\Controllers\adminpnlx\UserController::class, 'create'])->name('User.create');
Route::post('/users/store', [App\Http\Controllers\adminpnlx\UserController::class, 'store'])->name('User.store');
Route::get('/users/edit/{id}', [App\Http\Controllers\adminpnlx\UserController::class, 'edit'])->name('User.edit');
Route::post('/users/update/{id}', [App\Http\Controllers\adminpnlx\UserController::class, 'update'])->name('User.update');
Route::get('/users/delete/{id}', [App\Http\Controllers\adminpnlx\UserController::class, 'destroy'])->name('User.destroy');
Route::get('/users/image-delete/{id}', [App\Http\Controllers\adminpnlx\UserController::class, 'deleteImage'])->name('User.deleteImage');
Route::get('/users/my-account', [App\Http\Controllers\adminpnlx\UserController::class, 'myAccount'])->name('User.myAccount');

Route::get('/users/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\UserController::class, 'changeStatus'])->name('User.changeStatus');
Route::get('/users/change-password/{id}', [App\Http\Controllers\adminpnlx\UserController::class, 'changedPassword'])->name('User.changedPassword');
Route::post('/users/change-password/{id}', [App\Http\Controllers\adminpnlx\UserController::class, 'changedPassword'])->name('User.changedPassword');
Route::get('/users/send-credential/{id}', [App\Http\Controllers\adminpnlx\UserController::class, 'sendCredential'])->name('User.sendCredential');
Route::get('/users/export', [App\Http\Controllers\adminpnlx\UserController::class, 'userExport'])->name('User.userExport');
Route::get('/users/import', [App\Http\Controllers\adminpnlx\UserController::class, 'userImport'])->name('User.userImport');


// Staff 
Route::get('/staff', [App\Http\Controllers\adminpnlx\StaffController::class, 'index'])->name('Staff.index');
Route::get('/staff/view/{id}', [App\Http\Controllers\adminpnlx\StaffController::class, 'show'])->name('Staff.show');
Route::get('/staff/create', [App\Http\Controllers\adminpnlx\StaffController::class, 'create'])->name('Staff.create');
Route::post('/staff/store', [App\Http\Controllers\adminpnlx\StaffController::class, 'store'])->name('Staff.store');
Route::get('/staff/edit/{id}', [App\Http\Controllers\adminpnlx\StaffController::class, 'edit'])->name('Staff.edit');
Route::post('/staff/update/{id}', [App\Http\Controllers\adminpnlx\StaffController::class, 'update'])->name('Staff.update');
Route::get('/staff/delete/{id}', [App\Http\Controllers\adminpnlx\StaffController::class, 'destroy'])->name('Staff.destroy');
Route::get('/staff/image-delete/{id}', [App\Http\Controllers\adminpnlx\StaffController::class, 'deleteImage'])->name('Staff.deleteImage');
Route::post('/staff/designation', [App\Http\Controllers\adminpnlx\StaffController::class, 'designation'])->name('Staff.designation');
Route::post('/staff/permission', [App\Http\Controllers\adminpnlx\StaffController::class, 'permission'])->name('Staff.permission');
Route::post('/staff/acl-module', [App\Http\Controllers\adminpnlx\StaffController::class, 'aclModule'])->name('Staff.aclModule');

Route::get('/staff/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\StaffController::class, 'changeStatus'])->name('Staff.changeStatus');
Route::get('/staff/change-password/{id}', [App\Http\Controllers\adminpnlx\StaffController::class, 'changedPassword'])->name('Staff.changedPassword');
Route::post('/staff/change-password/{id}', [App\Http\Controllers\adminpnlx\StaffController::class, 'changedPassword'])->name('Staff.changedPassword');
Route::get('/staff/send-credential/{id}', [App\Http\Controllers\adminpnlx\StaffController::class, 'sendCredential'])->name('Staff.sendCredential');
Route::get('/staff/export', [App\Http\Controllers\adminpnlx\StaffController::class, 'staffExport'])->name('Staff.staffExport');
Route::get('/staff/import', [App\Http\Controllers\adminpnlx\StaffController::class, 'staffImport'])->name('Staff.staffImport');


/* Department Management */
Route::get('/departments', [App\Http\Controllers\adminpnlx\DepartmentController::class, 'index'])->name('Department.index');
Route::get('/departments/create', [App\Http\Controllers\adminpnlx\DepartmentController::class, 'create'])->name('Department.create');
Route::post('/departments/store', [App\Http\Controllers\adminpnlx\DepartmentController::class, 'store'])->name('Department.store');
Route::get('/departments/edit/{id}', [App\Http\Controllers\adminpnlx\DepartmentController::class, 'edit'])->name('Department.edit');
Route::post('/departments/update/{id}', [App\Http\Controllers\adminpnlx\DepartmentController::class, 'update'])->name('Department.update');
Route::get('/departments/delete/{id}', [App\Http\Controllers\adminpnlx\DepartmentController::class, 'destroy'])->name('Department.delete');
Route::get('/departments/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\DepartmentController::class, 'changeStatus'])->name('Department.changeStatus');

// designations
Route::get('/designations/{encatid?}', [App\Http\Controllers\adminpnlx\DesignationController::class, 'index'])->name('Designation.index');
Route::get('/designations/create/{encatid?}', [App\Http\Controllers\adminpnlx\DesignationController::class, 'create'])->name('Designation.create');
Route::post('/designations/store/{encatid?}', [App\Http\Controllers\adminpnlx\DesignationController::class, 'store'])->name('Designation.store');
Route::get('/designations/edit/{id}/{encatid?}', [App\Http\Controllers\adminpnlx\DesignationController::class, 'edit'])->name('Designation.edit');
Route::post('/designations/update/{id}/{encatid?}', [App\Http\Controllers\adminpnlx\DesignationController::class, 'update'])->name('Designation.update');
Route::get('/designations/delete/{id}/{encatid?}', [App\Http\Controllers\adminpnlx\DesignationController::class, 'destroy'])->name('Designation.delete');
Route::get('/designations/status-update/{id}/{status}/{encatid?}', [App\Http\Controllers\adminpnlx\DesignationController::class, 'changeStatus'])->name('Designation.changeStatus');

/* Department Management */


/* Banner */
Route::get('/banners', [App\Http\Controllers\adminpnlx\BannerController::class, 'index'])->name('Banner.index');
Route::get('/banners/view/{id}', [App\Http\Controllers\adminpnlx\BannerController::class, 'Show'])->name('Banner.show');
Route::get('/banners/create', [App\Http\Controllers\adminpnlx\BannerController::class, 'create'])->name('Banner.create');
Route::post('/banners/store', [App\Http\Controllers\adminpnlx\BannerController::class, 'store'])->name('Banner.store');
Route::get('/banners/edit/{id}', [App\Http\Controllers\adminpnlx\BannerController::class, 'edit'])->name('Banner.edit');
Route::post('/banners/update/{id}', [App\Http\Controllers\adminpnlx\BannerController::class, 'update'])->name('Banner.update');
Route::get('/banners/delete/{id}', [App\Http\Controllers\adminpnlx\BannerController::class, 'destroy'])->name('Banner.delete');
Route::get('/banners/image-delete/{id}', [App\Http\Controllers\adminpnlx\BannerController::class, 'deleteImage'])->name('Banner.deleteImage');
Route::get('/banners/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\BannerController::class, 'changeStatus'])->name('Banner.changeStatus');

/* Banner */

/* blogs management  */
Route::get('/blogs', [App\Http\Controllers\adminpnlx\BlogController::class, 'index'])->name('Blog.index');
Route::get('/blogs/view/{id}', [App\Http\Controllers\adminpnlx\BlogController::class, 'Show'])->name('Blog.show');
Route::get('/blogs/create', [App\Http\Controllers\adminpnlx\BlogController::class, 'create'])->name('Blog.create');
Route::post('/blogs/store', [App\Http\Controllers\adminpnlx\BlogController::class, 'store'])->name('Blog.store');
Route::get('/blogs/edit/{id}', [App\Http\Controllers\adminpnlx\BlogController::class, 'edit'])->name('Blog.edit');
Route::post('/blogs/update/{id}', [App\Http\Controllers\adminpnlx\BlogController::class, 'update'])->name('Blog.update');
Route::get('/blogs/delete/{id}', [App\Http\Controllers\adminpnlx\BlogController::class, 'delete'])->name('Blog.delete');
Route::get('/blogs/image-delete/{id}', [App\Http\Controllers\adminpnlx\BlogController::class, 'deleteImage'])->name('Blog.deleteImage');
Route::get('/blogs/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\BlogController::class, 'changeStatus'])->name('Blog.changeStatus');
Route::get('/blogs/edit-blogs-title', [App\Http\Controllers\adminpnlx\BlogController::class, 'edit_setting_title'])->name('Blog.edit_setting_title');
Route::post('/blogs/edit-blogs-title', [App\Http\Controllers\adminpnlx\BlogController::class, 'edit_setting_title'])->name('Blog.edit_setting_title');
/* blogs management  */

/* Order Management */
Route::get('/order', [App\Http\Controllers\adminpnlx\OrderController::class, 'index'])->name('Order.index');
Route::get('/order/view/{id}', [App\Http\Controllers\adminpnlx\OrderController::class, 'Show'])->name('Order.show');

// product order cancellation
Route::get('/order-cancel-request', [App\Http\Controllers\adminpnlx\OrderCancelController::class, 'index'])->name('OrderCancel.index');
Route::get('/order-cancel-request/view/{id}', [App\Http\Controllers\adminpnlx\OrderCancelController::class, 'Show'])->name('OrderCancel.show');
Route::get('/order-cancel-request/delete/{id}', [App\Http\Controllers\adminpnlx\OrderCancelController::class, 'delete'])->name('OrderCancel.delete');
Route::get('/order-cancel-request/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\OrderCancelController::class, 'changeStatus'])->name('OrderCancel.changeStatus');


// product order return
Route::get('/order-return-request', [App\Http\Controllers\adminpnlx\OrderReturnController::class, 'index'])->name('OrderReturn.index');
Route::get('/order-return-request/view/{id}', [App\Http\Controllers\adminpnlx\OrderReturnController::class, 'Show'])->name('OrderReturn.show');
Route::get('/order-return-request/delete/{id}', [App\Http\Controllers\adminpnlx\OrderReturnController::class, 'delete'])->name('OrderReturn.delete');
Route::get('/order-return-request/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\OrderReturnController::class, 'changeStatus'])->name('OrderReturn.changeStatus');
/* order Management */


// product order refund
Route::get('/order-refund-request', [App\Http\Controllers\adminpnlx\OrderRefundController::class, 'index'])->name('OrderRefund.index');
Route::get('/order-refund-request/view/{id}', [App\Http\Controllers\adminpnlx\OrderRefundController::class, 'Show'])->name('OrderRefund.show');
Route::get('/order-refund-request/delete/{id}', [App\Http\Controllers\adminpnlx\OrderRefundController::class, 'delete'])->name('OrderRefund.delete');
Route::get('/order-refund-request/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\OrderRefundController::class, 'changeStatus'])->name('OrderRefund.changeStatus');
/* order Management */



/* payments Management */
Route::get('/payments', [App\Http\Controllers\adminpnlx\PaymentController::class, 'index'])->name('Payment.index');
Route::get('/payments/view/{id}', [App\Http\Controllers\adminpnlx\PaymentController::class, 'Show'])->name('Payment.show');
Route::get('/payments/delete/{id}', [App\Http\Controllers\adminpnlx\PaymentController::class, 'destroy'])->name('Payment.delete');
Route::get('/payments/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\PaymentController::class, 'changeStatus'])->name('Payment.changeStatus');
/* payments Management */



/* Product Management */
// categories
Route::get('/categories', [App\Http\Controllers\adminpnlx\CategoryController::class, 'index'])->name('Category.index');
Route::get('/categories/view/{id}', [App\Http\Controllers\adminpnlx\CategoryController::class, 'Show'])->name('Category.show');
Route::get('/categories/create', [App\Http\Controllers\adminpnlx\CategoryController::class, 'create'])->name('Category.create');
Route::post('/categories/store', [App\Http\Controllers\adminpnlx\CategoryController::class, 'store'])->name('Category.store');
Route::get('/categories/edit/{id}', [App\Http\Controllers\adminpnlx\CategoryController::class, 'edit'])->name('Category.edit');
Route::post('/categories/update/{id}', [App\Http\Controllers\adminpnlx\CategoryController::class, 'update'])->name('Category.update');
Route::get('/categories/delete/{id}', [App\Http\Controllers\adminpnlx\CategoryController::class, 'destroy'])->name('Category.delete');
Route::get('/categories/image-delete/{id}', [App\Http\Controllers\adminpnlx\CategoryController::class, 'deleteImage'])->name('Category.deleteImage');
Route::get('/categories/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\CategoryController::class, 'changeStatus'])->name('Category.changeStatus');

// sub categories
Route::get('/sub-categories/{encatid?}', [App\Http\Controllers\adminpnlx\SubCategoryController::class, 'index'])->name('SubCategory.index');
Route::get('/sub-categories/view/{id}/{encatid?}', [App\Http\Controllers\adminpnlx\SubCategoryController::class, 'Show'])->name('SubCategory.show');
Route::get('/sub-categories/create/{encatid?}', [App\Http\Controllers\adminpnlx\SubCategoryController::class, 'create'])->name('SubCategory.create');
Route::post('/sub-categories/store/{encatid?}', [App\Http\Controllers\adminpnlx\SubCategoryController::class, 'store'])->name('SubCategory.store');
Route::get('/sub-categories/edit/{id}/{encatid?}', [App\Http\Controllers\adminpnlx\SubCategoryController::class, 'edit'])->name('SubCategory.edit');
Route::post('/sub-categories/update/{id}/{encatid?}', [App\Http\Controllers\adminpnlx\SubCategoryController::class, 'update'])->name('SubCategory.update');
Route::get('/sub-categories/delete/{id}/{encatid?}', [App\Http\Controllers\adminpnlx\SubCategoryController::class, 'destroy'])->name('SubCategory.delete');
Route::get('/sub-categories/image-delete/{id}/{encatid?}', [App\Http\Controllers\adminpnlx\SubCategoryController::class, 'deleteImage'])->name('SubCategory.deleteImage');
Route::get('/sub-categories/status-update/{id}/{status}/{encatid?}', [App\Http\Controllers\adminpnlx\SubCategoryController::class, 'changeStatus'])->name('SubCategory.changeStatus');

// Products
Route::get('/products', [App\Http\Controllers\adminpnlx\ProductController::class, 'index'])->name('Product.index');
Route::get('/products/view/{id}', [App\Http\Controllers\adminpnlx\ProductController::class, 'Show'])->name('Product.show');
Route::get('/products/create', [App\Http\Controllers\adminpnlx\ProductController::class, 'create'])->name('Product.create');
Route::post('/products/store', [App\Http\Controllers\adminpnlx\ProductController::class, 'store'])->name('Product.store');
Route::get('/products/edit/{id}', [App\Http\Controllers\adminpnlx\ProductController::class, 'edit'])->name('Product.edit');
Route::post('/products/update/{id}', [App\Http\Controllers\adminpnlx\ProductController::class, 'update'])->name('Product.update');
Route::get('/products/delete/{id}', [App\Http\Controllers\adminpnlx\ProductController::class, 'delete'])->name('Product.delete');
Route::get('/products/image-delete/{id}', [App\Http\Controllers\adminpnlx\ProductController::class, 'deleteImage'])->name('Product.deleteImage');
Route::get('/products/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\ProductController::class, 'changeStatus'])->name('Product.changeStatus');
Route::match(['get', 'post'], '/products/export/{id?}', [App\Http\Controllers\adminpnlx\ProductController::class, 'export'])->name('Product.export');
Route::match(['get', 'post'], '/products/import', [App\Http\Controllers\adminpnlx\ProductController::class, 'import'])->name('Product.import');
Route::match(['get', 'post'], '/products/import-list', [App\Http\Controllers\adminpnlx\ProductController::class, 'importList'])->name('Product.importList');
Route::match(['get', 'post'], '/products/import-data', [App\Http\Controllers\adminpnlx\ProductController::class, 'importListdata'])->name('Product.importListdata');
/* Product Management */



/* Coupons */
Route::get('/coupons', [App\Http\Controllers\adminpnlx\CouponController::class, 'index'])->name('Coupon.index');
Route::get('/coupons/view/{id}', [App\Http\Controllers\adminpnlx\CouponController::class, 'Show'])->name('Coupon.show');
Route::get('/coupons/create', [App\Http\Controllers\adminpnlx\CouponController::class, 'create'])->name('Coupon.create');
Route::post('/coupons/store', [App\Http\Controllers\adminpnlx\CouponController::class, 'store'])->name('Coupon.store');
Route::get('/coupons/edit/{id}', [App\Http\Controllers\adminpnlx\CouponController::class, 'edit'])->name('Coupon.edit');
Route::post('/coupons/update/{id}', [App\Http\Controllers\adminpnlx\CouponController::class, 'update'])->name('Coupon.update');
Route::get('/coupons/delete/{id}', [App\Http\Controllers\adminpnlx\CouponController::class, 'destroy'])->name('Coupon.destroy');
Route::get('/coupons/image-delete/{id}', [App\Http\Controllers\adminpnlx\CouponController::class, 'deleteImage'])->name('Coupon.deleteImage');
Route::get('/coupons/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\CouponController::class, 'changeStatus'])->name('Coupon.changeStatus');
/* Coupons */


/* Reports */
Route::get('/reports', [App\Http\Controllers\adminpnlx\ReportController::class, 'index'])->name('Report.index');
Route::get('/reports/view/{id}', [App\Http\Controllers\adminpnlx\ReportController::class, 'Show'])->name('Report.show');
Route::get('/reports/delete/{id}', [App\Http\Controllers\adminpnlx\ReportController::class, 'destroy'])->name('Report.destroy');
Route::get('/reports/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\ReportController::class, 'changeStatus'])->name('Report.changeStatus');
/* Reports */


/* Rating And Reviews */
Route::get('/ratings', [App\Http\Controllers\adminpnlx\RatingController::class, 'index'])->name('Rating.index');
Route::get('/ratings/view/{id}', [App\Http\Controllers\adminpnlx\RatingController::class, 'Show'])->name('Rating.show');
Route::get('/ratings/delete/{id}', [App\Http\Controllers\adminpnlx\RatingController::class, 'delete'])->name('Rating.delete');
Route::get('/ratings/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\RatingController::class, 'changeStatus'])->name('Rating.changeStatus');


// Reviews
Route::get('/reviews', [App\Http\Controllers\adminpnlx\ReviewController::class, 'index'])->name('Review.index');
Route::get('/reviews/view/{id}', [App\Http\Controllers\adminpnlx\ReviewController::class, 'Show'])->name('Review.show');
Route::post('/reviews/update/{id}', [App\Http\Controllers\adminpnlx\ReviewController::class, 'update'])->name('Review.update');
Route::get('/reviews/delete/{id}', [App\Http\Controllers\adminpnlx\ReviewController::class, 'delete'])->name('Review.delete');
Route::get('/reviews/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\ReviewController::class, 'changeStatus'])->name('Review.changeStatus');

Route::get('/reviews-rating', [App\Http\Controllers\adminpnlx\ReviewAndRatingController::class, 'index'])->name('ReviewAndRating.index');
Route::get('/reviews-rating/view/{id}', [App\Http\Controllers\adminpnlx\ReviewAndRatingController::class, 'Show'])->name('ReviewAndRating.show');
Route::get('/reviews-rating/edit/{id}', [App\Http\Controllers\adminpnlx\ReviewAndRatingController::class, 'edit'])->name('ReviewAndRating.edit');
Route::post('/reviews-rating/update/{id}', [App\Http\Controllers\adminpnlx\ReviewAndRatingController::class, 'update'])->name('ReviewAndRating.update');
Route::get('/reviews-rating/delete/{id}', [App\Http\Controllers\adminpnlx\ReviewAndRatingController::class, 'delete'])->name('ReviewAndRating.delete');
Route::get('/reviews-rating/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\ReviewAndRatingController::class, 'changeStatus'])->name('ReviewAndRating.changeStatus');

/* Rating And Reviews */


/* Lookups manager  module  routing start here */
Route::get('/lookups-manager/{type}', [App\Http\Controllers\adminpnlx\LookupsController::class, 'index'])->name('LookupManager.index');
Route::get('/lookups-manager/create/{type}', [App\Http\Controllers\adminpnlx\LookupsController::class, 'create'])->name('LookupManager.create');
Route::post('/lookups-manager/store/{type}', [App\Http\Controllers\adminpnlx\LookupsController::class, 'store'])->name('LookupManager.store');
Route::get('/lookups-manager/{type?}/edit/{id}', [App\Http\Controllers\adminpnlx\LookupsController::class, 'edit'])->name('LookupManager.edit');
Route::post('/lookups-manager/{type?}/update/{id}', [App\Http\Controllers\adminpnlx\LookupsController::class, 'update'])->name('LookupManager.update');
Route::get('/lookups-manager/delete/{id?}', [App\Http\Controllers\adminpnlx\LookupsController::class, 'delete'])->name('LookupManager.delete');
Route::get('/lookups-manager/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\LookupsController::class, 'changeStatus'])->name('LookupManager.changeStatus');
/* Lookups manager  module  routing start here */

/* masters management  */
// sizes
Route::get('/sizes', [App\Http\Controllers\adminpnlx\SizeController::class, 'index'])->name('Size.index');
Route::get('/sizes/view/{id}', [App\Http\Controllers\adminpnlx\SizeController::class, 'Show'])->name('Size.show');
Route::get('/sizes/create', [App\Http\Controllers\adminpnlx\SizeController::class, 'create'])->name('Size.create');
Route::post('/sizes/store', [App\Http\Controllers\adminpnlx\SizeController::class, 'store'])->name('Size.store');
Route::get('/sizes/edit/{id}', [App\Http\Controllers\adminpnlx\SizeController::class, 'edit'])->name('Size.edit');
Route::post('/sizes/update/{id}', [App\Http\Controllers\adminpnlx\SizeController::class, 'update'])->name('Size.update');
Route::get('/sizes/delete/{id}', [App\Http\Controllers\adminpnlx\SizeController::class, 'delete'])->name('Size.delete');
Route::get('/sizes/image-delete/{id}', [App\Http\Controllers\adminpnlx\SizeController::class, 'deleteImage'])->name('Size.deleteImage');
Route::get('/sizes/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\SizeController::class, 'changeStatus'])->name('Size.changeStatus');

// colors
Route::get('/colors', [App\Http\Controllers\adminpnlx\ColorController::class, 'index'])->name('Color.index');
Route::get('/colors/view/{id}', [App\Http\Controllers\adminpnlx\ColorController::class, 'Show'])->name('Color.show');
Route::get('/colors/create', [App\Http\Controllers\adminpnlx\ColorController::class, 'create'])->name('Color.create');
Route::post('/colors/store', [App\Http\Controllers\adminpnlx\ColorController::class, 'store'])->name('Color.store');
Route::get('/colors/edit/{id}', [App\Http\Controllers\adminpnlx\ColorController::class, 'edit'])->name('Color.edit');
Route::post('/colors/update/{id}', [App\Http\Controllers\adminpnlx\ColorController::class, 'update'])->name('Color.update');
Route::get('/colors/delete/{id}', [App\Http\Controllers\adminpnlx\ColorController::class, 'delete'])->name('Color.delete');
Route::get('/colors/image-delete/{id}', [App\Http\Controllers\adminpnlx\ColorController::class, 'deleteImage'])->name('Color.deleteImage');
Route::get('/colors/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\ColorController::class, 'changeStatus'])->name('Color.changeStatus');

// Brands
Route::get('/brands', [App\Http\Controllers\adminpnlx\BrandController::class, 'index'])->name('Brand.index');
Route::get('/brands/view/{id}', [App\Http\Controllers\adminpnlx\BrandController::class, 'Show'])->name('Brand.show');
Route::get('/brands/create', [App\Http\Controllers\adminpnlx\BrandController::class, 'create'])->name('Brand.create');
Route::post('/brands/store', [App\Http\Controllers\adminpnlx\BrandController::class, 'store'])->name('Brand.store');
Route::get('/brands/edit/{id}', [App\Http\Controllers\adminpnlx\BrandController::class, 'edit'])->name('Brand.edit');
Route::post('/brands/update/{id}', [App\Http\Controllers\adminpnlx\BrandController::class, 'update'])->name('Brand.update');
Route::get('/brands/delete/{id}', [App\Http\Controllers\adminpnlx\BrandController::class, 'delete'])->name('Brand.delete');
Route::get('/brands/image-delete/{id}', [App\Http\Controllers\adminpnlx\BrandController::class, 'deleteImage'])->name('Brand.deleteImage');
Route::get('/brands/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\BrandController::class, 'changeStatus'])->name('Brand.changeStatus');
/* masters management  */




/* system management */

// cms Pages
Route::get('/cms-managers', [App\Http\Controllers\adminpnlx\CmsPageController::class, 'index'])->name('CmsPage.index');
Route::get('/cms-managers/view/{id}', [App\Http\Controllers\adminpnlx\CmsPageController::class, 'Show'])->name('CmsPage.show');
Route::get('/cms-managers/create', [App\Http\Controllers\adminpnlx\CmsPageController::class, 'create'])->name('CmsPage.create');
Route::post('/cms-managers/store', [App\Http\Controllers\adminpnlx\CmsPageController::class, 'store'])->name('CmsPage.store');
Route::get('/cms-managers/edit/{id}', [App\Http\Controllers\adminpnlx\CmsPageController::class, 'edit'])->name('CmsPage.edit');
Route::post('/cms-managers/update/{id}', [App\Http\Controllers\adminpnlx\CmsPageController::class, 'update'])->name('CmsPage.update');
Route::get('/cms-managers/delete/{id}', [App\Http\Controllers\adminpnlx\CmsPageController::class, 'destroy'])->name('CmsPage.destroy');
Route::get('/cms-managers/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\CmsPageController::class, 'changeStatus'])->name('CmsPage.changeStatus');

// Faq
Route::get('/faqs', [App\Http\Controllers\adminpnlx\FaqController::class, 'index'])->name('Faq.index');
Route::get('/faqs/view/{id}', [App\Http\Controllers\adminpnlx\FaqController::class, 'Show'])->name('Faq.show');
Route::get('/faqs/create', [App\Http\Controllers\adminpnlx\FaqController::class, 'create'])->name('Faq.create');
Route::post('/faqs/store', [App\Http\Controllers\adminpnlx\FaqController::class, 'store'])->name('Faq.store');
Route::get('/faqs/edit/{id}', [App\Http\Controllers\adminpnlx\FaqController::class, 'edit'])->name('Faq.edit');
Route::post('/faqs/update/{id}', [App\Http\Controllers\adminpnlx\FaqController::class, 'update'])->name('Faq.update');
Route::get('/faqs/delete/{id}', [App\Http\Controllers\adminpnlx\FaqController::class, 'destroy'])->name('Faq.destroy');
Route::get('/faqs/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\FaqController::class, 'changeStatus'])->name('Faq.changeStatus');


// EmailTemplate
Route::get('/email-templates', [App\Http\Controllers\adminpnlx\EmailTemplateController::class, 'index'])->name('EmailTemplate.index');
Route::get('/email-templates/view/{id}', [App\Http\Controllers\adminpnlx\EmailTemplateController::class, 'Show'])->name('EmailTemplate.show');
Route::get('/email-templates/create', [App\Http\Controllers\adminpnlx\EmailTemplateController::class, 'create'])->name('EmailTemplate.create');
Route::post('/email-templates/store', [App\Http\Controllers\adminpnlx\EmailTemplateController::class, 'store'])->name('EmailTemplate.store');
Route::get('/email-templates/edit/{id}', [App\Http\Controllers\adminpnlx\EmailTemplateController::class, 'edit'])->name('EmailTemplate.edit');
Route::post('/email-templates/update/{id}', [App\Http\Controllers\adminpnlx\EmailTemplateController::class, 'update'])->name('EmailTemplate.update');
Route::get('/email-templates/delete/{id}', [App\Http\Controllers\adminpnlx\EmailTemplateController::class, 'destroy'])->name('EmailTemplate.destroy');
Route::get('/email-templates/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\EmailTemplateController::class, 'changeStatus'])->name('EmailTemplate.changeStatus');


// EmailLog
Route::get('/email-logs', [App\Http\Controllers\adminpnlx\EmailLogController::class, 'index'])->name('EmailLog.index');
Route::match(['get', 'post'], '/email-logs/email-details', [App\Http\Controllers\adminpnlx\EmailLogController::class, 'emailDetail'])->name('EmailLog.emailDetail');
Route::get('/email-logs/delete/{id}', [App\Http\Controllers\adminpnlx\EmailLogController::class, 'destroy'])->name('EmailLog.delete');


// SeoPageManager
Route::get('/seo-page-manager', [App\Http\Controllers\adminpnlx\SeoPageController::class, 'index'])->name('SeoPage.index');
Route::get('/seo-page-manager/view/{id}', [App\Http\Controllers\adminpnlx\SeoPageController::class, 'Show'])->name('SeoPage.show');
Route::get('/seo-page-manager/create', [App\Http\Controllers\adminpnlx\SeoPageController::class, 'create'])->name('SeoPage.create');
Route::post('/seo-page-manager/store', [App\Http\Controllers\adminpnlx\SeoPageController::class, 'store'])->name('SeoPage.store');
Route::get('/seo-page-manager/edit/{id}', [App\Http\Controllers\adminpnlx\SeoPageController::class, 'edit'])->name('SeoPage.edit');
Route::post('/seo-page-manager/update/{id}', [App\Http\Controllers\adminpnlx\SeoPageController::class, 'update'])->name('SeoPage.update');
Route::get('/seo-page-manager/delete/{id}', [App\Http\Controllers\adminpnlx\SeoPageController::class, 'destroy'])->name('SeoPage.destroy');
Route::get('/seo-page-manager/image-delete/{id}', [App\Http\Controllers\adminpnlx\SeoPageController::class, 'deleteImage'])->name('SeoPage.deleteImage');
Route::get('/seo-page-manager/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\SeoPageController::class, 'changeStatus'])->name('SeoPage.changeStatus');
/* system management */



//news-letters 
Route::get('/news-letters', [App\Http\Controllers\adminpnlx\NewsLetterController::class, 'index'])->name('NewsLetters.index');
Route::get('/news-letters/view/{id}', [App\Http\Controllers\adminpnlx\NewsLetterController::class, 'Show'])->name('NewsLetters.show');
Route::get('/news-letters/create', [App\Http\Controllers\adminpnlx\NewsLetterController::class, 'create'])->name('NewsLetters.create');
Route::post('/news-letters/store', [App\Http\Controllers\adminpnlx\NewsLetterController::class, 'store'])->name('NewsLetters.store');
Route::get('/news-letters/delete/{id}', [App\Http\Controllers\adminpnlx\NewsLetterController::class, 'delete'])->name('NewsLetters.delete');

// notifications
Route::get('/notifications', [App\Http\Controllers\adminpnlx\NotificationController::class, 'index'])->name('Notification.index');
Route::get('/notifications/view/{id}', [App\Http\Controllers\adminpnlx\NotificationController::class, 'Show'])->name('Notification.show');
Route::get('/notifications/delete/{id}', [App\Http\Controllers\adminpnlx\NotificationController::class, 'delete'])->name('Notification.delete');


/** settings **/
Route::resource('settings', App\Http\Controllers\adminpnlx\SettingController::class);
Route::get('/settings/prefix/{enslug?}', [App\Http\Controllers\adminpnlx\SettingController::class, 'prefix'])->name('settings.prefix');
Route::post('/settings/prefix/{enslug?}', [App\Http\Controllers\adminpnlx\SettingController::class, 'prefix'])->name('settings.prefix');
Route::get('settings/destroy/{ensetid?}', [App\Http\Controllers\adminpnlx\SettingController::class, 'destroy'])->name('settings.delete');
  /** settings **/



// contact-enquiry
Route::get('/contact-enquiry', [App\Http\Controllers\adminpnlx\ContactEnquiryController::class, 'index'])->name('ContactEnquiry.index');
Route::get('/contact-enquiry/view/{id}', [App\Http\Controllers\adminpnlx\ContactEnquiryController::class, 'Show'])->name('ContactEnquiry.show');
Route::get('/contact-enquiry/delete/{id}', [App\Http\Controllers\adminpnlx\ContactEnquiryController::class, 'delete'])->name('ContactEnquiry.delete');
Route::get('/contact-enquiry/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\ContactEnquiryController::class, 'changeStatus'])->name('ContactEnquiry.changeStatus');
Route::post('/contact-enquiry-reply/{id}', [App\Http\Controllers\adminpnlx\ContactEnquiryController::class, 'reply'])->name('ContactEnquiry.reply');


// language-setting
Route::get('/languages', [App\Http\Controllers\adminpnlx\LanguageController::class, 'index'])->name('Language.index');
Route::get('/languages/view/{id}', [App\Http\Controllers\adminpnlx\LanguageController::class, 'Show'])->name('Language.show');
Route::get('/languages/create', [App\Http\Controllers\adminpnlx\LanguageController::class, 'create'])->name('Language.create');
Route::post('/languages/store', [App\Http\Controllers\adminpnlx\LanguageController::class, 'store'])->name('Language.store');
Route::get('/languages/edit/{id}', [App\Http\Controllers\adminpnlx\LanguageController::class, 'edit'])->name('Language.edit');
Route::post('/languages/update/{id}', [App\Http\Controllers\adminpnlx\LanguageController::class, 'update'])->name('Language.update');
Route::get('/languages/delete/{id}', [App\Http\Controllers\adminpnlx\LanguageController::class, 'destroy'])->name('Language.destroy');
Route::get('/languages/image-delete/{id}', [App\Http\Controllers\adminpnlx\LanguageController::class, 'deleteImage'])->name('Language.deleteImage');
Route::get('/languages/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\LanguageController::class, 'changeStatus'])->name('Language.changeStatus');


// language-setting
Route::get('/language-setting', [App\Http\Controllers\adminpnlx\LanguageSettingController::class, 'index'])->name('LanguageSetting.index');
Route::get('/language-setting/view/{id}', [App\Http\Controllers\adminpnlx\LanguageSettingController::class, 'Show'])->name('LanguageSetting.show');
Route::get('/language-setting/create', [App\Http\Controllers\adminpnlx\LanguageSettingController::class, 'create'])->name('LanguageSetting.create');
Route::post('/language-setting/store', [App\Http\Controllers\adminpnlx\LanguageSettingController::class, 'store'])->name('LanguageSetting.store');
Route::get('/language-setting/edit/{id}', [App\Http\Controllers\adminpnlx\LanguageSettingController::class, 'edit'])->name('LanguageSetting.edit');
Route::post('/language-setting/update/{id}', [App\Http\Controllers\adminpnlx\LanguageSettingController::class, 'update'])->name('LanguageSetting.update');
Route::get('/language-setting/delete/{id}', [App\Http\Controllers\adminpnlx\LanguageSettingController::class, 'destroy'])->name('LanguageSetting.destroy');
Route::get('/language-setting/status-update/{id}/{status}', [App\Http\Controllers\adminpnlx\LanguageSettingController::class, 'changeStatus'])->name('LanguageSetting.changeStatus');

  });

});


