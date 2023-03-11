<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MyTransactionController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\ProductCategoryController;
use Illuminate\Support\Facades\URL;

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

// Route::get('/dashboard2', function() {
//     return view('dashboard2');
// });

// Route::get('/dashboard2', [DashboardController::class, 'statusDashboard']);


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    // Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/', [DashboardController::class, 'statusDashboard'])->name('index');

    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        // Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/', [DashboardController::class, 'statusDashboard'])->name('index');

        Route::middleware(['admin'])->group(function () {
            Route::resource('product', ProductController::class);
            Route::get('exportAllProducts',[ProductController::class,'exportProducts'])->name('product.exportProducts');
            Route::resource('category', ProductCategoryController::class);
            Route::resource('product.gallery', ProductGalleryController::class)->shallow()->only([
                'index', 'create', 'store', 'destroy'
            ]);
            Route::get('exportProductCategories',[ProductCategoryController::class,'exportProductCategories'])->name('category.exportProductCategories');
            Route::resource('transaction', TransactionController::class)->only([
                'index', 'show', 'edit', 'update'
            ]);
            // Route::resource('transaction', TransactionController::class);
            Route::get('exportAllTransactions', [TransactionController::class,'exportAllTransactions'])->name('transaction.exportAllTransactions');
            Route::get('transactionAllTransaction',[TransactionController::class, 'indexAllTransaction'])->name('transaction.indexAllTransaction');
            Route::get('transactionPending',[TransactionController::class, 'indexPending'])->name('transaction.indexPending');
            Route::get('transactionSuccess',[TransactionController::class, 'indexSuccess'])->name('transaction.indexSuccess');
            Route::get('transactionCancelled',[TransactionController::class, 'indexCancelled'])->name('transaction.indexCancelled');
            // Route::resource('transaction/pending', TransactionController::class)->only([
            //     'indexPending', 'show', 'edit', 'update'
            // ]);
            // Route::resource('transaction/pending', TransactionController::class);
            Route::resource('user', UserController::class)->only([
                'index', 'edit', 'update', 'destroy'
            ]);

            Route::post('importUserAll', [UserController::class,'importUserAll'])->name('user.importUserAll');
            Route::get('exportRoleAdmin', [UserController::class,'exportRoleAdmin'])->name('user.exportRoleAdmin');
            Route::get('exportRoleUser', [UserController::class,'exportRoleUser'])->name('user.exportRoleUser');
            Route::get('exportUsers', [UserController::class,'exportUsers'])->name('user.export');
            Route::get('userAdmin', [UserController::class,'indexUserAdmin'])->name('user.indexUserAdmin');
            Route::get('userCustomer', [UserController::class,'indexUserCustomer'])->name('user.indexUserCustomer');
        });
    });
});
