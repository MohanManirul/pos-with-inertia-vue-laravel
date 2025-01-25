<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\TokenVarificationAPIMiddleware;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// users
Route::post('user-registration',[UserController::class,'userRegistration'])->name('userRegistration');
Route::post('user-login',[UserController::class,'userLogin'])->name('userLogin');
Route::get('user-logout',[UserController::class,'userLogout'])->name('userLogout');
Route::post('send-otp',[UserController::class,'sendOtp'])->name('sendOtp');
Route::post('varify-otp',[UserController::class,'varifyOtp'])->name('varifyOtp');
Route::post('reset-pass',[UserController::class,'resetPassword'])->name('resetPassword')->middleware(TokenVarificationAPIMiddleware::class);

//category
Route::get('/list-category',[CategoryController::class,'listCategory'])->name('listCategory')->middleware(TokenVarificationAPIMiddleware::class);
Route::post('/create-category',[CategoryController::class,'createCategory'])->name('createCategory')->middleware(TokenVarificationAPIMiddleware::class);
Route::post('/update-category',[CategoryController::class,'updateCategory'])->name('updateCategory')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('/delete-category',[CategoryController::class,'deleteCategory'])->name('deleteCategory')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('/category-by-id',[CategoryController::class,'categoryById'])->name('categoryById')->middleware(TokenVarificationAPIMiddleware::class);


//customer
Route::post('/create-customer',[CustomerController::class,'createCustomer'])->name('createCustomer')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('/list-customer',[CustomerController::class,'listCustomer'])->name('createCustomer')->middleware(TokenVarificationAPIMiddleware::class);
Route::post('/update-customer',[CustomerController::class,'updateCustomer'])->name('updateCustomer')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('/delete-customer',[CustomerController::class,'deleteCustomer'])->name('deleteCustomer')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('/customer-by-id',[CustomerController::class,'customerById'])->name('customerById')->middleware(TokenVarificationAPIMiddleware::class);

// products
Route::post('/create-product',[ProductController::class,'createProduct'])->name('createProduct')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('/list-product',[ProductController::class,'listProduct'])->name('listProduct')->middleware(TokenVarificationAPIMiddleware::class);
Route::post('/delete-product',[ProductController::class,'deleteProduct'])->name('deleteProduct')->middleware(TokenVarificationAPIMiddleware::class);
Route::post('/update-product',[ProductController::class,'updateProduct'])->name('updateProduct')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('/product-by-id',[ProductController::class,'productById'])->name('productById')->middleware(TokenVarificationAPIMiddleware::class);


//invoice
Route::post('create-invoice',[InvoiceController::class,'createInvoice'])->name('createInvoice')->middleware(TokenVarificationAPIMiddleware::class);
Route::post('delete-invoice',[InvoiceController::class,'deleteInvoice'])->name('deleteInvoice')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('list-invoice',[InvoiceController::class,'listInvoice'])->name('listInvoice')->middleware(TokenVarificationAPIMiddleware::class);
Route::get('invoce-details',[InvoiceController::class,'invoiceDetails'])->name('invoiceDetails')->middleware(TokenVarificationAPIMiddleware::class);
