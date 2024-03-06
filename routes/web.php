<?php

use App\Http\Controllers\FactorController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Factor;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/user-exists', function () {
     $userExists = Artisan::call('sms:command', [
        'email' => 'papa@example.com'
    ]);
});

Route::get('mongodb',[\App\Http\Controllers\MongoDbController::class,'mongodb']);

Route::get('sendemail', [MailController::class, 'sendemail']);

Route::view('/login', 'authorize.login')->name('login');

Route::view('/register', 'authorize.register')->name('register');

Route::get('/workplace', function () {
    $customer_count = User::count();
    $factor_count = Factor::count();
    $order_count = Order::count();
    $product_count = Product::count();
    return view('workplace', compact('customer_count', 'factor_count', 'order_count', 'product_count'));
})->name('workplace')->middleware('auth:sanctum');

Route::get('/error/', function () {
//    dd('kkk');
    return view('error');
})->name('error');

//users
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('web_permission:admin,seller,customer');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('web_permission:admin');
    Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('web_permission:admin');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('web_permission:admin,seller,customer');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('web_permission:admin,seller,customer');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('web_permission:admin');
    Route::get('users/status',[UserController::class,'status'])->name('users.status')->middleware('web_permission:admin');
    Route::get('users/confirmed/{user}',[UserController::class,'confirmed'])->name('users.confirmed')->middleware('web_permission:admin');
    Route::get('users/reject/{user}',[UserController::class,'reject'])->name('users.reject')->middleware('web_permission:admin');
    Route::get('users/filter',[UserController::class,'filter'])->name('users.filter')->middleware('web_permission:admin');

});
Route::post('/users/register', [UserController::class, 'UserRegister'])->name('users.register');
Route::any('/users/login', [UserController::class, 'UserLogin'])->name('users.login');
Route::get('/users/logout', [UserController::class, 'UserLogout'])->name('users.logout');
Route::get('/login/github', [UserController::class, 'github'])->name('users.github');
Route::get('/callback/github', [UserController::class, 'callbackgithub'])->name('users.callback');

//products
Route::middleware('auth:sanctum')->middleware('web_permission:admin,seller')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::patch('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/filter', [ProductController::class, 'filter'])->name('product.filter');

});

//orders
Route::middleware('auth:sanctum')->middleware('web_permission:admin,seller,customer')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::patch('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{id}/delete', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/filter', [OrderController::class, 'filter'])->name('orders.filter');

});

Route::middleware('auth:sanctum')->middleware('web_permission:admin')->group(function () {
    Route::get('/factors', [FactorController::class, 'index'])->name('factors.index');
    Route::get('/factors/create', [FactorController::class, 'create'])->name('factors.create');
    Route::delete('/factors/{factor}/delete', [FactorController::class, 'destroy'])->name('factors.destroy');
    Route::get('/factors/{factor}/edit', [FactorController::class, 'edit'])->name('factors.edit');
    Route::put('/factors/{factor}', [FactorController::class, 'update'])->name('factors.update');
    Route::get('/factors/trashed', [FactorController::class, 'trashed'])->name('factors.trashed');
    Route::post('/factors/{id}/recovery', [FactorController::class, 'recovery'])->name('factors.recovery');

    Route::get('/factors/filter', [FactorController::class, 'filter'])->name('factors.filter')->middleware('web_permission:admin,seller,customer');
});
Route::post('/factors', [FactorController::class, 'store'])->name('factors.store')->middleware('web_permission:admin,seller,customer');
Route::get('/factors/{order}/create', [FactorController::class, 'ordercreate'])->name('factors.order.create')->middleware('web_permission:admin,seller,customer');
