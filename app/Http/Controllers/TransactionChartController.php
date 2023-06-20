<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Charts\TransactionYearChart;
use App\Http\Controllers\Controller;

class TransactionChartController extends Controller
{
    // public function index(Request $request)
    // {
    //     // Ambil semua tahun yang tersedia pada database
    //     $availableYears = DB::table('transactions')
    //         ->selectRaw('YEAR(created_at) as year')
    //         ->groupBy('year')
    //         ->pluck('year')
    //         ->toArray();

    //     // Ambil input tahun dari user, atau gunakan tahun saat ini sebagai default
    //     $year = $request->input('year') ?? date('Y');

    //     // Validasi input tahun: jika tahun tidak tersedia, redirect ke halaman dengan tahun saat ini
    //     if (!in_array($year, $availableYears)) {
    //         sleep(3); // Jeda 3 detik untuk mencegah brute force
    //         return redirect()->route('dashboard.chart.chartTransactions', ['year' => date('Y')])->withError('Tahun yang dimasukkan tidak tersedia.');
    //     }

    //     // Ambil data transaksi dari database berdasarkan status, tahun, dan bulan
    //     $transactions = Transaction::selectRaw('status, YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
    //         ->when($year, function ($query) use ($year) {
    //             return $query->whereYear('created_at', $year);
    //         })
    //         ->groupBy('status', 'year', 'month')
    //         ->orderBy('status', 'asc')
    //         ->orderBy('year', 'asc')
    //         ->orderBy('month', 'asc')
    //         ->get();

    //     // Buat chart baru
    //     $chart = new TransactionYearChart;

    //     // Tambahkan label bulan dan tahun pada chart
    //     $labels = [];
    //     for ($month = 1; $month <= 12; $month++) {
    //         // Menambahkan bulan ke array label
    //         $labels[] = date('F Y', mktime(0, 0, 0, $month, 1, $year));
    //     }
    //     $chart->labels($labels);

    //     // Tambahkan dataset baru pada chart berdasarkan status, tahun, dan bulan
    //     $statuses = $transactions->pluck('status')->unique();
    //     foreach ($statuses as $status) {
    //         $statusData = [];
    //         for ($month = 1; $month <= 12; $month++) {
    //             $total = $transactions->where('status', $status)->where('year', $year)->where('month', $month)->first()->total ?? 0;
    //             array_push($statusData, $total);
    //         }

    //         $color = $status == 'PENDING' ? '#ffc107' : ($status == 'SUCCESS' ? '#28a745' : '#dc3545');
    //         $chart->dataset($status, 'bar', $statusData)
    //             ->backgroundColor($color);
    //     }

    //     // Tampilkan view dengan chart dan data lainnya
    //     return view('pages.dashboard.chart.index_transaction_tahun', [
    //         'chart' => $chart,
    //         'currentYear' => $year,
    //         'availableYears' => $availableYears
    //     ]);
    // }

    // public function index(Request $request)
    // {
    //     // Ambil semua tahun yang tersedia pada database
    //     $availableYears = DB::table('transactions')
    //         ->selectRaw('YEAR(created_at) as year')
    //         ->groupBy('year')
    //         ->pluck('year')
    //         ->toArray();

    //     // Ambil input tahun dari user, atau gunakan tahun saat ini sebagai default
    //     $year = $request->input('year') ?? date('Y');
    //     // Ambil data transaksi dari database berdasarkan status, tahun, dan bulan
    //     $transactions = Transaction::selectRaw('status, YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_price) as total_price')
    //         ->when($year, function ($query) use ($year) {
    //             return $query->whereYear('created_at', $year);
    //         })
    //         ->groupBy('status', 'year', 'month')
    //         ->orderBy('status', 'asc')
    //         ->orderBy('year', 'asc')
    //         ->orderBy('month', 'asc')
    //         ->get();

    //     if (count($transactions) == 0) {
    //         return redirect()->route('dashboard.chart.chartVirtualBisnis')->withError('Data transaksi tidak tersedia, tidak bisa memasuki halaman.');
    //     } else if (!in_array($year, $availableYears)) {
    //         sleep(3); // Jeda 3 detik untuk mencegah brute force
    //         return redirect()->route('dashboard.chart.chartTransactions', ['year' => date('Y')])->withError('Tahun yang dimasukkan tidak tersedia.');
    //     }

    //     // Buat chart baru
    //     $chart = new TransactionYearChart;

    //     // Tambahkan label bulan dan tahun pada chart
    //     $labels = [];
    //     for ($month = 1; $month <= 12; $month++) {
    //         // Menambahkan bulan ke array label
    //         $labels[] = date('F Y', mktime(0, 0, 0, $month, 1, $year));
    //     }
    //     $chart->labels($labels);

    //     // Tambahkan dataset baru pada chart berdasarkan status, tahun, dan bulan
    //     $statuses = $transactions->pluck('status')->unique();
    //     foreach ($statuses as $status) {
    //         $statusData = [];
    //         for ($month = 1; $month <= 12; $month++) {
    //             $totalPrice = $transactions->where('status', $status)->where('year', $year)->where('month', $month)->first()->total_price ?? 0;
    //             array_push($statusData, number_format($totalPrice, 0,',','.'));
    //         }

    //         $color = $status == 'PENDING' ? '#ffc107' : ($status == 'SUCCESS' ? '#28a745' : '#dc3545');
    //         $chart->dataset($status, 'bar', $statusData)
    //             ->backgroundColor($color);
    //     }

    //     // Tampilkan view dengan chart dan data lainnya
    //     return view('pages.dashboard.chart.index_transaction_tahun', [
    //         'chart' => $chart,
    //         'currentYear' => $year,
    //         'availableYears' => $availableYears
    //     ]);
    // }

    public function index(Request $request)
{
    // Ambil semua tahun yang tersedia pada database
    $availableYears = Transaction::selectRaw('YEAR(created_at) as year')
        ->groupBy('year')
        ->pluck('year')
        ->toArray();

    // Ambil input tahun dari user, atau gunakan tahun saat ini sebagai default
    $year = $request->input('year') ?? date('Y');

    // Ambil data transaksi dari database berdasarkan status, tahun, dan bulan
    $transactions = Transaction::selectRaw('status, YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_price) as total_price')
        ->when($year, function ($query) use ($year) {
            $query->whereYear('created_at', $year);
        })
        ->groupBy('status', 'year', 'month')
        ->orderBy('status')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

    if ($transactions->isEmpty()) {
        return redirect()->route('dashboard.chart.chartVirtualBisnis')->withError('Data transaksi tidak tersedia, tidak bisa memasuki halaman.');
    }

    if (!in_array($year, $availableYears)) {
        sleep(3); // Jeda 3 detik untuk mencegah brute force
        return redirect()->route('dashboard.chart.chartTransactions', ['year' => date('Y')])->withError('Tahun yang dimasukkan tidak tersedia.');
    }

    // Buat chart baru
    $chart = new TransactionYearChart;

    // Tambahkan label bulan dan tahun pada chart
    $labels = [];
    for ($month = 1; $month <= 12; $month++) {
        $labels[] = date('F Y', mktime(0, 0, 0, $month, 1, $year));
    }
    $chart->labels($labels);

    // Tambahkan dataset baru pada chart berdasarkan status, tahun, dan bulan
    $statuses = $transactions->pluck('status')->unique();
    foreach ($statuses as $status) {
        $statusData = [];
        for ($month = 1; $month <= 12; $month++) {
            $totalPrice = $transactions->where('status', $status)
                ->where('year', $year)
                ->where('month', $month)
                ->first()->total_price ?? 0;
            $statusData[] = $totalPrice;
        }

        $color = $status == 'PENDING' ? '#ffc107' : ($status == 'SUCCESS' ? '#28a745' : '#dc3545');
        $chart->dataset($status, 'bar', $statusData)
            ->backgroundColor($color);
    }

    // Tampilkan view dengan chart dan data lainnya
    return view('pages.dashboard.chart.index_transaction_tahun', compact('chart', 'year', 'availableYears'));
}


}
