<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Charts\UserChart;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Charts\TransactionChart;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Charts\UserRegistrationChart;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard');
    }

    public function statusDashboard()
    {
        // $usersChart = new UserChart;
        // $usersChart->labels(['Jan', 'Feb', 'Mar']);
        // $usersChart->dataset('Users by trimester', 'line', [10, 25, 13])
        //     ->backgroundColor([
        //         'rgba(128, 0, 128, 0.2)',
        //         'rgba(148, 0, 211, 0.2)',
        //         'rgba(238, 130, 238, 0.2)'
        //     ]);

        $numberOfMonths = 6;
        $userRegistrationChart = new UserRegistrationChart;
        $userRegistrationChart->labels($userRegistrationChart->getUserRegistrationData($numberOfMonths)['labels']);
        $userRegistrationChart->dataset('Users Registered', 'line', $userRegistrationChart->getUserRegistrationData($numberOfMonths)['data'])
            ->backgroundColor('rgba(54, 162, 235, 0.2)');

        // $numberOfMonths = 6;
        // $userRegistrationChart = new UserRegistrationChart;
        // $userRegistrationChart->labels($userRegistrationChart->getUserRegistrationData($numberOfMonths)['labels']);

        // // Mengambil data jumlah pengguna untuk setiap role
        // $userData = [];
        // $adminData = [];
        // for ($i = 1; $i <= $numberOfMonths; $i++) {
        //     $month = date('m', strtotime("-$i month"));
        //     $year = date('Y', strtotime("-$i month"));

        //     $usersCount = User::where('roles', 'USER')
        //         ->whereMonth('created_at', $month)
        //         ->whereYear('created_at', $year)
        //         ->count();
        //     array_unshift($userData, $usersCount);

        //     $adminsCount = User::where('roles', 'ADMIN')
        //         ->whereMonth('created_at', $month)
        //         ->whereYear('created_at', $year)
        //         ->count();
        //     array_unshift($adminData, $adminsCount);
        // }

        // // Set data untuk role "User"
        // $userRegistrationChart->dataset('Users', 'line', $userData)
        //     ->backgroundColor('rgba(54, 162, 235, 0.2)');

        // // Set data untuk role "Admin"
        // $userRegistrationChart->dataset('Admins', 'line', $adminData)
        //     ->backgroundColor('rgba(255, 99, 132, 0.2)');

        // // Render chart
        // $userRegistrationChart->options([
        //     'scales' => [
        //         'yAxes' => [
        //             [
        //                 'ticks' => [
        //                     'beginAtZero' => true
        //                 ]
        //             ]
        //         ]
        //     ]
        // ]);



        // Inisialisasi chart
        $usersChart = new UserChart;

        // Set label untuk chart
        $usersChart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']);

        // Mengambil data jumlah pengguna untuk setiap role
        $userData = [];
        $adminData = [];

        for ($i = 1; $i <= 6; $i++) {
            $month = date('m', strtotime("-$i month"));
            $year = date('Y', strtotime("-$i month"));

            $usersCount = User::where('roles', 'USER')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count();
            array_unshift($userData, $usersCount);

            $adminsCount = User::where('roles', 'ADMIN')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count();
            array_unshift($adminData, $adminsCount);
        }

        // Set data untuk role "User"
        $userDataset = $usersChart->dataset('Users', 'line', $userData)
            ->backgroundColor('rgba(54, 162, 235, 0.2)');

        // Set data untuk role "Admin"
        $adminDataset = $usersChart->dataset('Admins', 'line', $adminData)
            ->backgroundColor('rgba(255, 99, 132, 0.2)');

        $transactionChart = new TransactionChart;
        $transactionChart->labels(['Pending', 'Success', 'Cancelled']);
        $transactionChart->dataset('Transaction Status', 'bar', $transactionChart->getTransactionData())
            ->backgroundColor([
                '#FF6384',
                '#36A2EB',
                '#FFCE56'
            ]);

        $users_count = User::count();
        $new_transaction = Transaction::count();

        $list_transaction = Transaction::orderBy('total_price', 'desc')->get();

        $total_amount_success = Transaction::where('status', '=', 'SUCCESS')->sum('total_price');
        $total_amount_pending = Transaction::where('status', '=', 'PENDING')->sum('total_price');

        if (request()->ajax()) {
            // $query = Transaction::with(['user'])->orderByDesc('created_at');
            $query = Transaction::with(['user'])->orderByDesc('created_at');

            return DataTables::of($query)
                ->addColumn('user.name', function ($item) {
                    return '
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <!-- Avatar with inset shadow -->
                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                    ' . (Jetstream::managesProfilePhotos() ?
                        (Auth::user()->profile_photo_url ? '
                                            <img class="object-cover w-full h-full rounded-full"
                                                src="' . Auth::user()->profile_photo_url . '"
                                                alt="' . $item->user->name . '" loading="lazy" />' : '
                                            <img class="object-cover w-full h-full rounded-full"
                                                src="' . asset('img/default-avatar.jpg') . '"
                                                alt="' . $item->user->name . '" loading="lazy" />'
                        ) : '
                                        <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.22 0-4 1.78-4 4s1.78 4 4 4 4-1.78 4-4-1.78-4-4-4zm0 6c-1.11 0-2-.89-2-2s.89-2 2-2 2 .89 2 2-.89 2-2 2z" />
                                            </svg>
                                        </span>
                                    ') . '
                                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                </div>
                                <div>
                                    <p class="font-semibold">' . $item->user->name . '</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">@' . $item->user->username . '</p>
                                </div>
                            </div>
                        </td>
                    ';
                })

                ->addColumn('status', function ($item) {
                    if ($item->status == 'SUCCESS') {
                        return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    ' . $item->status . '
                                </span>
                            </td>
                        ';
                    } elseif ($item->status == 'PENDING') {
                        return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                    ' . $item->status . '
                                </span>
                            </td>
                        ';
                    } elseif ($item->status == 'CANCELLED') {
                        return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                    ' . $item->status . '
                                </span>
                            </td>
                        ';
                    } else {
                        return '
                            <td class="px-4 py-3 text-xs">
                                Not Found!
                            </td>
                        ';
                    }
                })

                ->addColumn('action', function ($item) {
                    return '
                        <a class="inline-block border border-blue-500 bg-blue-400 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline"
                            href="' . route('dashboard.transaction.show', $item->id) . '">
                            <i class="fa fa-eye"></i> Lihat
                        </a>
                        <a class="inline-block border border-yellow-500 bg-yellow-400 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                            href="' . route('dashboard.transaction.edit', $item->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>';
                })
                // ->editColumn('total_price', function ($item) {
                //     return number_format($item->total_price).'.00';
                // })
                ->rawColumns(['user.name', 'status', 'action'])
                ->make();
        }
        return view(
            'dashboard2',
            compact(
                'users_count',
                'new_transaction',
                'list_transaction',
                'total_amount_success',
                'total_amount_pending',
                'usersChart',
                'transactionChart',
                'userRegistrationChart',

            )
        );
    }

    // public function UserChart()
    // {
    //     $usersChart = new UserChart;
    //     $usersChart->labels(['Jan', 'Feb', 'Mar']);
    //     $usersChart->dataset('Users by trimester', 'line', [10, 25, 13]);
    //     return view('')
    // }

}
