<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\permissionsController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\rolesController;
use App\Http\Controllers\usersController;
use App\Models\Stock;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::post('ajax/{method}', [App\Http\Controllers\AjaxController::class, 'handle'])->name('ajax.handle');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::resource('/brand', \App\Http\Controllers\BrandController::class);
    Route::resource('/category', \App\Http\Controllers\CategoryController::class);
    Route::resource('/product', \App\Http\Controllers\ProductController::class);
    Route::resource('/warehouse', \App\Http\Controllers\WarehouseController::class);
    Route::resource('/account', \App\Http\Controllers\AccountController::class);

    Route::get('/purchase', [\App\Http\Controllers\PurchaseController::class, 'payment'])->name('purchase.payment');
    Route::resource('/purchase', \App\Http\Controllers\PurchaseController::class);
    Route::resource('/unit', \App\Http\Controllers\UnitController::class);
    Route::resource('/purchaseReceive', \App\Http\Controllers\PurchaseReceiveController::class);
    Route::resource('/sale', \App\Http\Controllers\SaleController::class);
    Route::resource('/saleDelivered', \App\Http\Controllers\SaleDeliveredController::class);
    Route::resource('/salePayment', \App\Http\Controllers\SalePaymentController::class);

    Route::resource('/purchaseReceive',\App\Http\Controllers\PurchaseReceiveController::class);

    Route::get('/stocks','App\Http\Controllers\StockController@index')->name('stock.index');
    Route::get('/stocks/{stockDetails}','App\Http\Controllers\StockController@show')->name('stock.show');

    Route::get('/reset', function() {
        Artisan::call('migrate:fresh --seed');
          return back()->with('message', 'Reset Successful');
        })->name('reset');

    Route::get('/users', [usersController::class, 'index']);
    Route::get('/user/add', [usersController::class, 'add']);
    Route::post('/user/create', [usersController::class, 'create']);
    Route::get('/user/permissions/{id}', [usersController::class, 'viewPermissions']);
    Route::get('/user/edit/{id}', [usersController::class, 'editUser']);
    Route::post('/user/update', [usersController::class, 'update']);
    Route::post('/user/assignRole', [usersController::class, 'assignRole']);
    Route::post('/user/assignPermissions', [usersController::class, 'assignPermissions']);
    Route::get('/user/role/revoke/{id}/{role}', [usersController::class, 'revokeRole']);
    Route::get('/roles', [rolesController::class, 'index']);
    Route::get('/role/edit/{id}', [rolesController::class, 'edit']);
    Route::post('/role/update', [rolesController::class, 'update']);
    Route::post('/roles/store', [rolesController::class, 'store']);
    Route::post('/role/updatePermissions', [rolesController::class, 'updatePermissions']);
    Route::get('/permissions', [permissionsController::class, 'index']);
    /* Route::post('/permissions/store', [permissionsController::class, 'store']); */
});
