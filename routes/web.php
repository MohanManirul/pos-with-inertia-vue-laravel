<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\SessionAuthenticateMiddleware;
use Illuminate\Support\Facades\Route;

// ================== User Routes ==================

Route::post('user-registration', [UserController::class, 'userRegistration'])->name('userRegistration');
Route::post('user-login', [UserController::class, 'userLogin'])->name('userLogin');
Route::get('user-logout', [UserController::class, 'userLogout'])->name('userLogout');
Route::post('send-otp', [UserController::class, 'sendOtp'])->name('sendOtp');
Route::post('verify-otp', [UserController::class, 'verifyOtp'])->name('verifyOtp');
Route::post('reset-pass', [UserController::class, 'resetPassword'])->name('resetPassword')->middleware(SessionAuthenticateMiddleware::class);

// User Page Routes
Route::get('/registration-page', [UserController::class, 'registrationPage'])->name('registrationPage');
Route::get('/login-page', [UserController::class, 'loginPage'])->name('loginPage');
Route::get('/send-otp-page', [UserController::class, 'sendOtpPage'])->name('sendOtpPage');
Route::get('/verify-otp-page', [UserController::class, 'verifyOtpPage'])->name('verifyOtpPage');
Route::get('/reset-password-page', [UserController::class, 'resetPasswordPage'])->name('resetPasswordPage');

// ================== Middleware Protected Routes ==================
Route::middleware([SessionAuthenticateMiddleware::class])->group(function () {

    // Dashboard Routes
    Route::get('/dashboard-page', [DashboardController::class, 'dashboardPage'])->name('dashboardPage');
    Route::get('/sale-page', [DashboardController::class, 'salePage'])->name('salePage');
    Route::get('/invoice-page', [InvoiceController::class, 'listInvoice'])->name('listInvoice');

    // Category Routes
    Route::post('/create-category', [CategoryController::class, 'createCategory'])->name('createCategory');
    Route::post('/update-category', [CategoryController::class, 'updateCategory'])->name('updateCategory');
    Route::get('/delete-category', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');

    // Customer Routes
    Route::post('/create-customer', [CustomerController::class, 'createCustomer'])->name('createCustomer');
    Route::post('/update-customer', [CustomerController::class, 'updateCustomer'])->name('updateCustomer');
    Route::get('/delete-customer', [CustomerController::class, 'deleteCustomer'])->name('deleteCustomer');

    // Product Routes
    Route::post('/create-product', [ProductController::class, 'createProduct'])->name('createProduct');
    Route::post('/update-product', [ProductController::class, 'updateProduct'])->name('updateProduct');
    Route::get('/delete-product', [ProductController::class, 'deleteProduct'])->name('deleteProduct');

    // Invoice Routes
    Route::post('/create-invoice', [InvoiceController::class, 'createInvoice'])->name('createInvoice');
    Route::get('/delete-invoice', [InvoiceController::class, 'deleteInvoice'])->name('deleteInvoice');
});

// ================== Page Routes ==================
Route::middleware([SessionAuthenticateMiddleware::class])->group(function () {
    // Category Pages
    Route::get('/category-page', [CategoryController::class, 'categoryPage'])->name('categoryPage');
    Route::get('/category-save-page', [CategoryController::class, 'categorySavePage'])->name('categorySavePage');

    // Customer Pages
    Route::get('/customer-page', [CustomerController::class, 'customerPage'])->name('customerPage');
    Route::get('/customer-save-page', [CustomerController::class, 'customerSavePage'])->name('customerSavePage');

    // Product Pages
    Route::get('/product-page', [ProductController::class, 'productPage'])->name('productPage');
    Route::get('/product-save-page', [ProductController::class, 'productSavePage'])->name('productSavePage');
});
