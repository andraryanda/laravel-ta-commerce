<?php

namespace App\Http\Controllers;

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
                    $encryptedId = Crypt::encrypt($item->id);

                    return '
                    <div class="flex justify-start items-center space-x-3.5">
                        <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
                            class="inline-flex flex-col items-center justify-center w-20 h-12 bg-green-400 text-white rounded-md border border-green-500 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">WhatsApp</p>
                        </a>
                        <a href="' . route('dashboard.report.exportPDF', $encryptedId) . '" title="Kwitansi"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/printer.png') . '" alt="printer" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Kwitansi</p>
                        </a>
                        <a href="' . route('dashboard.transaction.show', $encryptedId) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                    </div>



                    ';
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
                'users_customer_count',
                'new_transaction',
                'list_transaction',
                'total_amount_success',
                'total_amount_pending',
                'transactionChart',
                'userRegistrationChart',
                'productChart',
                'transactionPriceChart',

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

    // public function UserChart()
    // {
    //     $usersChart = new UserChart;
    //     $usersChart->labels(['Jan', 'Feb', 'Mar']);
    //     $usersChart->dataset('Users by trimester', 'line', [10, 25, 13]);
    //     return view('')
    // }

}
