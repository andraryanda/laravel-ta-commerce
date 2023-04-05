<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Charts\UserChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserChartController extends Controller
{

    public function index(Request $request)
    {
        // Ambil semua tahun yang tersedia pada database
        $availableYears = DB::table('users')
            ->selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->pluck('year')
            ->toArray();

        // Ambil input tahun dari user, atau gunakan tahun saat ini sebagai default
        $year = $request->input('year') ?? date('Y');

        // // Validasi input tahun: jika tahun tidak tersedia, redirect ke halaman dengan tahun saat ini
        // if (!in_array($year, $availableYears)) {
        //     sleep(3); // Jeda 3 detik untuk mencegah brute force
        //     return redirect()->route('dashboard.chart.chartUsers', ['year' => date('Y')])->withError('Tahun yang dimasukkan tidak tersedia.');
        // }

        // Ambil data pengguna dari database berdasarkan role, tahun, dan bulan
        $users = User::selectRaw('roles, YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('created_at', $year);
            })
            ->groupBy('roles', 'year', 'month')
            ->orderBy('roles', 'asc')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();


        if (count($users) == 0) {
            return redirect()->route('dashboard.chart.chartUsers')->withError('Data users tidak tersedia, tidak bisa memasuki halaman.');
        } else if (!in_array($year, $availableYears)) {
            sleep(3); // Jeda 3 detik untuk mencegah brute force
            return redirect()->route('dashboard.chart.chartUsers', ['year' => date('Y')])->withError('Tahun yang dimasukkan tidak tersedia.');
        }

        // Buat chart baru
        $chart = new UserChart;

        // Tambahkan label bulan dan tahun pada chart
        $labels = [];
        for ($month = 1; $month <= 12; $month++) {
            // Menambahkan bulan ke array label
            $labels[] = date('F Y', mktime(0, 0, 0, $month, 1, $year));
        }
        $chart->labels($labels);

        // Tambahkan dataset baru pada chart berdasarkan role, tahun, dan bulan
        $roles = $users->pluck('roles')->unique();
        foreach ($roles as $role) {
            $roleData = [];
            for ($month = 1; $month <= 12; $month++) {
                $total = $users->where('roles', $role)->where('year', $year)->where('month', $month)->first()->total ?? 0;
                array_push($roleData, $total);
            }

            $color = $role == 'USER' ? '#007bff' : '#dc3545';
            $chart->dataset($role, 'bar', $roleData)
                ->backgroundColor($color);
        }

        // Tampilkan view dengan chart dan data lainnya
        return view('pages.dashboard.chart.index_user_tahun', [
            'chart' => $chart,
            'currentYear' => $year,
            'availableYears' => $availableYears
        ]);
    }
}

 // public function index(Request $request)
    // {
    //     $year = $request->input('year') ?? date('Y');

    //     // Ambil data dari database
    //     $users = User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
    //         ->when($year, function ($query) use ($year) {
    //             return $query->whereYear('created_at', $year);
    //         })
    //         ->groupBy('year', 'month')
    //         ->orderBy('year', 'asc')
    //         ->orderBy('month', 'asc')
    //         ->get();

    //     $chart = new UserChart;

    //     // Menambahkan label berdasarkan tahun dan bulan
    //     $chart->labels($users->map(function ($user) {
    //         return date('F Y', mktime(0, 0, 0, $user->month, 1, $user->year));
    //     }));

    //     // Menambahkan dataset baru berdasarkan tahun dan bulan
    //     $years = $users->pluck('year')->unique();
    //     foreach ($years as $year) {
    //         $totals = $users->where('year', $year)->pluck('total');
    //         $chart->dataset($year, 'bar', $totals);
    //     }

    //     return view('pages.dashboard.chart.dumy', [
    //         'chart' => $chart,
    //         'currentYear' => $year
    //     ]);
    // }



 // public function index()
    // {
    //     $users = User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
    //         ->groupBy('year', 'month')
    //         ->orderBy('year', 'asc')
    //         ->orderBy('month', 'asc')
    //         ->get();

    //     $chart = new UserChart;

    //     // Menambahkan label berdasarkan tahun dan bulan
    //     $chart->labels($users->map(function ($user) {
    //         return date('F Y', mktime(0, 0, 0, $user->month, 1, $user->year));
    //     }));

    //     // Menambahkan dataset baru berdasarkan tahun dan bulan
    //     $years = $users->pluck('year')->unique();
    //     foreach ($years as $year) {
    //         $totals = $users->where('year', $year)->pluck('total');
    //         $chart->dataset($year, 'bar', $totals);
    //     }

    //     return view('pages.dashboard.chart.dumy', ['chart' => $chart]);
    // }
