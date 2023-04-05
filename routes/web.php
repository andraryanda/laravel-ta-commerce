<?php

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserChartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\MyTransactionController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\TransactionChartController;
use App\Http\Controllers\LandingPage\AboutController;
use App\Http\Controllers\LandingPage\ContactController;
use App\Http\Controllers\LandingPage\HostingController;
use App\Http\Controllers\LandingPage\PricingController;
use App\Http\Controllers\LandingPage\HalamanUtamaController;
use App\Http\Controllers\Midtrans\MidtransWebhookController;

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
Route::get('/', [HalamanUtamaController::class, 'index'])->name('landingPage.index');
Route::get('about', [AboutController::class, 'index'])->name('landingPage.about');
Route::get('hosting', [HostingController::class, 'index'])->name('landingPage.hosting');
Route::get('contact', [ContactController::class, 'index'])->name('landingPage.contact');
Route::get('pages/pricing', [PricingController::class, 'index'])->name('landingPage.pricing');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('dashboard', [DashboardController::class, 'statusDashboard'])->name('dashboard.index');

    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        // Route::get('dashboard', [DashboardController::class, 'statusDashboard'])->name('index');

        Route::middleware(['admin'])->group(function () {
            Route::resource('product', ProductController::class);
            Route::get('exportAllProducts', [ProductController::class, 'exportProducts'])->name('product.exportProducts');
            Route::resource('category', ProductCategoryController::class);
            Route::resource('product.gallery', ProductGalleryController::class)->shallow()->only([
                'index', 'create', 'store', 'destroy'
            ]);
            Route::get('exportProductCategories', [ProductCategoryController::class, 'exportProductCategories'])->name('category.exportProductCategories');
            Route::post('importCategory', [ProductCategoryController::class, 'importCategory'])->name('category.importCategory');
            Route::resource('transaction', TransactionController::class)->only([
                'index', 'show', 'edit', 'update'
            ]);
            Route::get('sendMessage-{transaction}', [TransactionController::class, 'sendMessage'])->name('transaction.sendMessage');
            Route::get('exportPDF-{transaction}', [TransactionController::class, 'exportPDF'])->name('transaction.exportPDF');
            Route::get('exportAllTransactions', [TransactionController::class, 'exportAllTransactions'])->name('transaction.exportAllTransactions');
            Route::get('exportTransactionCancelled', [TransactionController::class, 'exportTransactionCancelled'])->name('transaction.exportTransactionCancelled');
            Route::get('exportTransactionSuccess', [TransactionController::class, 'exportTransactionSuccess'])->name('transaction.exportTransactionSuccess');
            Route::get('exportTransactionPending', [TransactionController::class, 'exportTransactionPending'])->name('transaction.exportTransactionPending');
            Route::get('transactionAllTransaction', [TransactionController::class, 'indexAllTransaction'])->name('transaction.indexAllTransaction');
            Route::get('transactionPending', [TransactionController::class, 'indexPending'])->name('transaction.indexPending');
            Route::get('transactionSuccess', [TransactionController::class, 'indexSuccess'])->name('transaction.indexSuccess');
            Route::get('transactionCancelled', [TransactionController::class, 'indexCancelled'])->name('transaction.indexCancelled');
            // Route::resource('transaction/pending', TransactionController::class)->only([
            //     'indexPending', 'show', 'edit', 'update'
            // ]);
            Route::resource('user', UserController::class)->only([
                'index', 'create', 'store', 'edit', 'update', 'destroy'
            ]);

            Route::get('createUserCustomer', [UserController::class, 'createUserCustomer'])->name('user.createUserCustomer');
            Route::get('createUserAdmin', [UserController::class, 'createUserAdmin'])->name('user.createUserAdmin');
            Route::post('importUserCustomer', [UserController::class, 'importUserCustomer'])->name('user.importUserCustomer');
            Route::post('importUserAdmin', [UserController::class, 'importUserAdmin'])->name('user.importUserAdmin');
            Route::post('importUserAll', [UserController::class, 'importUserAll'])->name('user.importUserAll');
            Route::get('exportRoleAdmin', [UserController::class, 'exportRoleAdmin'])->name('user.exportRoleAdmin');
            Route::get('exportRoleUser', [UserController::class, 'exportRoleUser'])->name('user.exportRoleUser');
            Route::get('exportUsers', [UserController::class, 'exportUsers'])->name('user.export');
            Route::get('userAdmin', [UserController::class, 'indexUserAdmin'])->name('user.indexUserAdmin');
            Route::get('userCustomer', [UserController::class, 'indexUserCustomer'])->name('user.indexUserCustomer');

            Route::get('chartUsers{year?}', [UserChartController::class, 'index'])->name('chart.chartUsers');
            Route::get('chartTransactions{year?}', [TransactionChartController::class, 'index'])->name('chart.chartTransactions');
            Route::get('chartVirtualBisnis', [ChartController::class, 'index'])->name('chart.chartVirtualBisnis');
            Route::get('report', [ReportController::class, 'index'])->name('report.laporanStore');

            Route::post('/reportExport', [ReportController::class, 'generateReport'])->name('report.exportGenerateUser');


            // Midtrans
            Route::get('dashboard/payment/cancel/{id}', [MidtransWebhookController::class, 'cancelPayment'])->name('midtrans.cancel');

            Route::get('transaction/{id}/payment', [MidtransWebhookController::class, 'payment'])->name('transaction.payment');
            Route::post('payment/notification', [MidtransWebhookController::class, 'notification'])->name('transaction.paymentNotification');
            Route::post('recurring/notification', [MidtransWebhookController::class, 'notificationHandler'])->name('transaction.recurring');
            Route::post('payAccount/notification', [MidtransWebhookController::class, 'handlePayAccountNotification'])->name('transaction.payAccount');
            Route::get('payment/finish/{id}', [MidtransWebhookController::class, 'handlefinish'])->name('payment.finish');
            Route::get('payment/unfinish/{id}', [MidtransWebhookController::class, 'handleUnfinish'])->name('payment.unfinish');
            Route::get('payment/error', [MidtransWebhookController::class, 'handleError'])->name('payment.error');
            Route::get('transactionShowMidtrans/{transaction}', [MidtransWebhookController::class, 'show'])->name('midtrans.show');


            // Route::post('/midtrans/webhook', [TransactionController::class, 'handleWebhook'])->name('transaction.handleWebhook');
        });
    });
});
