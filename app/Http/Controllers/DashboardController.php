<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Charts\UserChart;
use App\Models\Transaction;
use App\Charts\ProductChart;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use App\Charts\TransactionChart;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Charts\TransactionPriceChart;
use App\Charts\UserRegistrationChart;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use App\Models\NotificationTransaction;
use Yajra\DataTables\Facades\DataTables;
// use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard');
    }

    public function statusDashboard()
    {

        // Memanggil chart
        $numberOfMonths = 6;
        $userRegistrationChart = new UserRegistrationChart;
        $userCounts = $userRegistrationChart->getUserRegistrationData($numberOfMonths);
        $userRegistrationChart->labels($userCounts['labels']);
        $userRegistrationChart->dataset('Users', 'bar', collect($userCounts['userCounts'])->pluck('user_count'))
            ->backgroundColor('rgba(54, 162, 235, 0.2)');
        $userRegistrationChart->dataset('Admins', 'bar', collect($userCounts['userCounts'])->pluck('admin_count'))
            ->backgroundColor('rgba(255, 99, 132, 0.2)');
        $userRegistrationChart->options([
            'scales' => [
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                    ],
                ],
            ],
        ]);

        $transactionChart = new TransactionChart;
        $transactionChart->labels(['Pending', 'Success', 'Cancelled']);
        $transactionChart->dataset('Pending', 'bar', [$transactionChart->getTransactionData()[0]])
            ->backgroundColor('#FFCE56');
        $transactionChart->dataset('Success', 'bar', [$transactionChart->getTransactionData()[1]])
            ->backgroundColor('#36A2EB');
        $transactionChart->dataset('Cancelled', 'bar', [$transactionChart->getTransactionData()[2]])
            ->backgroundColor('#FF6384');


        // Memanggil chart
        $numberOfMonths = 6;
        $transactionPriceChart = new TransactionPriceChart;
        $transactionCounts = $transactionPriceChart->getTransactionPriceData($numberOfMonths);
        $transactionPriceChart->labels($transactionCounts['labels']);
        $transactionPriceChart->dataset('Pending', 'bar', $transactionCounts['pendingCounts'])
            ->backgroundColor('rgba(255, 159, 64, 0.2)');
        $transactionPriceChart->dataset('Success', 'bar', $transactionCounts['successCounts'])
            ->backgroundColor('rgba(54, 162, 235, 0.2)');
        $transactionPriceChart->dataset('Cancelled', 'bar', $transactionCounts['cancelledCounts'])
            ->backgroundColor('rgba(255, 99, 132, 0.2)');
        $transactionPriceChart->options([
            'scales' => [
                'yAxes' => [
                    [
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                    ],
                ],
            ],
        ]);

        // Mengambil data penjualan terbanyak pada 10 produk
        $bestSellingProducts = TransactionItem::join('products', 'transaction_items.products_id', '=', 'products.id')
            ->select('products.name as product_name', DB::raw('SUM(transaction_items.quantity) as total_quantity'))
            ->groupBy('transaction_items.products_id')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();

        // Inisialisasi chart
        $productChart = new ProductChart;

        // Set label untuk chart
        $productChart->labels($bestSellingProducts->pluck('product_name')->toArray());

        // Set data untuk jumlah produk yang terjual
        $productChart->dataset('Total Quantity Sold', 'bar', $bestSellingProducts->pluck('total_quantity')->toArray())
            ->backgroundColor([
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
            ])
            // Tambahkan label untuk setiap data produk
            ->label($bestSellingProducts->pluck('product_name')->toArray());

        $users_customer_count = User::where('roles', '=', 'USER')->count();
        $new_transaction = Transaction::count();
        $total_amount_success = Transaction::where('status', '=', 'SUCCESS')->sum('total_price');
        $total_amount_pending = Transaction::where('status', '=', 'PENDING')->sum('total_price');
        $list_transaction = Transaction::orderBy('total_price', 'desc')->get();

        $users = User::orderby('last_seen', 'desc')->get();

        $transactions = TransactionItem::select('products_id')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw("SUM(CASE WHEN transactions.status = 'SUCCESS' THEN 1 ELSE 0 END) as success_count")
            ->selectRaw("SUM(CASE WHEN transactions.status = 'PENDING' THEN 1 ELSE 0 END) as pending_count")
            ->selectRaw("SUM(CASE WHEN transactions.status = 'CANCELED' THEN 1 ELSE 0 END) as canceled_count")
            ->leftJoin('transactions', 'transaction_items.transactions_id', '=', 'transactions.id')
            ->whereNull('transaction_items.deleted_at')
            ->groupBy('products_id')
            ->get();

        $productNames = Product::whereIn('id', $transactions->pluck('products_id'))->pluck('name');

        $labels = $productNames->toArray();
        $successData = $transactions->pluck('success_count')->toArray();
        $pendingData = $transactions->pluck('pending_count')->toArray();
        $canceledData = $transactions->pluck('canceled_count')->toArray();
        return view(
            'dashboard2',
            compact(
                'users_customer_count',
                'new_transaction',
                'list_transaction',
                'total_amount_success',
                'total_amount_pending',
                'transactionChart',
                'userRegistrationChart',
                'productChart',
                'transactionPriceChart',
                'users',
                'labels',
                'successData',
                'pendingData',
                'canceledData'
            )
        );
    }

    public function indexDashboardCustomer()
    {

        $new_transaction = Transaction::where('users_id', Auth::user()->id)->count();
        $total_amount_success = Transaction::where('status', 'SUCCESS')->where('users_id', Auth::user()->id)->sum('total_price');
        $total_amount_pending = Transaction::where('status', 'PENDING')->where('users_id', Auth::user()->id)->sum('total_price');
        $list_transaction = Transaction::where('users_id', Auth::user()->id)->orderBy('total_price', 'desc')->get();


        return view('dashboardCustomer', compact(
            'new_transaction',
            'total_amount_success',
            'total_amount_pending',
            'list_transaction',
        ));
    }

    public function indexDashboardAdmin()
    {
        return view('dashboardAdmin');
    }
}
