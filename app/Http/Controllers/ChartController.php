<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Charts\ProductChart;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\TransactionItem;
use App\Charts\TransactionChart;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Charts\TransactionPriceChart;
use App\Charts\UserRegistrationChart;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $numberOfMonths = 6;
        // $userRegistrationChart = new UserRegistrationChart;
        // $userRegistrationChart->labels($userRegistrationChart->getUserRegistrationData($numberOfMonths)['labels']);
        // $userRegistrationChart->dataset('Users Registered', 'line', $userRegistrationChart->getUserRegistrationData($numberOfMonths)['data'])
        //     ->backgroundColor('rgba(54, 162, 235, 0.2)');

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
$transactionPriceChart->dataset('Pending', 'line', $transactionCounts['pendingCounts'])
    ->backgroundColor('rgba(255, 159, 64, 0.2)')
    ->color('rgba(255, 159, 64, 1)');
$transactionPriceChart->dataset('Success', 'line', $transactionCounts['successCounts'])
    ->backgroundColor('rgba(54, 162, 235, 0.2)')
    ->color('rgba(54, 162, 235, 1)');
$transactionPriceChart->dataset('Cancelled', 'line', $transactionCounts['cancelledCounts'])
    ->backgroundColor('rgba(255, 99, 132, 0.2)')
    ->color('rgba(255, 99, 132, 1)');
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

        // $users_count = User::where('roles', [])->count();
        $users_count = User::where('roles', '=', 'ADMIN')->orWhere('roles', '=', 'USER')->count();
        $total_admin_count = User::where('roles', '=', 'ADMIN')->count();
        $total_customer_count = User::where('roles', '=', 'USER')->count();

        $new_transaction = Transaction::count();
        $total_amount_success = Transaction::where('status', '=', 'SUCCESS')->sum('total_price');
        $total_amount_pending = Transaction::where('status', '=', 'PENDING')->sum('total_price');
        $total_amount_cancelled = Transaction::where('status', '=', 'CANCELLED')->sum('total_price');

        $categoryProduct_count = ProductCategory::count();
        $product_count = Product::count();

// =======================================================================================================

        // chart JS - transaction Produk
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

    // chart JS - transaction Produk (Harga)
    $totalPendingSales = Transaction::where('status', 'PENDING')->sum('total_price');
    $totalSuccessSales = Transaction::where('status', 'SUCCESS')->sum('total_price');
    $totalCancelledSales = Transaction::where('status', 'CANCELLED')->sum('total_price');

        return view(
            'pages.dashboard.chart.index',
            compact(
                'users_count',
                'total_admin_count',
                'total_customer_count',
                'total_amount_cancelled',
                'categoryProduct_count',
                'product_count',
                'new_transaction',
                'total_amount_success',
                'total_amount_pending',
                'transactionChart',
                'userRegistrationChart',
                'productChart',
                'transactionPriceChart',
                'labels', 'successData', 'pendingData', 'canceledData',
                'totalPendingSales', 'totalSuccessSales', 'totalCancelledSales',

            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
