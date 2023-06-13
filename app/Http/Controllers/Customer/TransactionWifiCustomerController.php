<?php

namespace App\Http\Controllers\Customer;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionWifi;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionWifiItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TransactionWifiRequest;
use App\Notifications\TransactionWifiNotification;
use Illuminate\Contracts\Encryption\DecryptException;

class TransactionWifiCustomerController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = TransactionWifi::with(['user','wifi_items.product'])
                ->where('users_id', Auth::user()->id)
                ->OrderByDesc('created_at');
                // ->get();
            return DataTables::of($query)
            ->editColumn('user.name', function ($item) {
                if ($item->user->profile_photo_url) {
                    return '
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <!-- Avatar with inset shadow -->
                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                    <img class="object-cover w-full h-full rounded-full" src="' . $item->user->profile_photo_url . '" alt="' . $item->user->name . '" loading="lazy" />
                                </div>
                                <div>
                                    <p class="font-semibold">' . $item->user->name . '</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">@' . $item->user->username . '</p>
                                </div>
                            </div>
                        </td>
                    ';
                } else {
                    return '
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.22 0-4 1.78-4 4s1.78 4 4 4 4-1.78 4-4-1.78-4-4-4zm0 6c-1.11 0-2-.89-2-2s.89-2 2-2 2 .89 2 2-.89 2-2 2z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-semibold">' . $item->user->name . '</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">@' . $item->user->username . '</p>
                                </div>
                            </div>
                        </td>
                    ';
                }
            })
            ->editColumn('status', function ($item) {
                if ($item->status == 'ACTIVE') {
                    // Periksa apakah masa expired_wifi telah lewat
                    $expiredDate = Carbon::parse($item->expired_wifi);

                    if ($expiredDate->isPast()) {
                        $statusText = 'INACTIVE'; // Mengubah status menjadi "INACTIVE"
                        $statusClass = 'text-red-700 bg-red-100';
                    } else {
                        $daysUntilExpired = $expiredDate->diffInDays(null, true); // Menggunakan $absolute = true
                        $statusText = 'Masa Wifi berakhir dalam ' . $daysUntilExpired . ' hari';

                        if ($daysUntilExpired < 7) {
                            $statusClass = 'text-yellow-700 bg-yellow-100';
                        } else {
                            $statusClass = 'text-green-700 bg-green-100';
                        }
                    }

                    return '
                        <td class="px-4 py-3 text-xs">
                            <span class="px-2 py-1 font-semibold leading-tight ' . $statusClass . ' rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                ' . $item->status . '
                                (' . $statusText . ')
                            </span>
                        </td>
                    ';
                } elseif ($item->status == 'INACTIVE') {
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
                ->editColumn('action', function ($item) {
                    $encryptedId = Crypt::encrypt($item->id);
                    // $status = $item->status;
                        return '
                    <div class="flex justify-start items-center space-x-3.5">
                        <a href="'. route('dashboard.midtrans.paymentWifi', $item->id) .'" target="_blank" title="Bayar"
                            class="flex flex-col shadow-sm items-center justify-center w-20 h-12 border border-purple-500 bg-purple-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-purple-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/credit-card.png') . '" alt="Bayar" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Bayar Wifi</p>
                        </a>
                        <a href="' . route('dashboard.bulan-customer.show', $encryptedId) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                    </div>
                    ';
                })
                ->rawColumns(['action','status','user.name'])
                ->make();
        }
        return view('pages.customer.pembayaran_wifi_bulan.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId); // Mendekripsi ID transaksi
            $transaction = TransactionWifi::with(['items','wifi_items'])->find($id);
            // $transactionWifiItem = TransactionWifiItem::where('transaction_wifi_id', $id)->first();
            // if (!$transaction) {
            //     // Lakukan penanganan jika transaksi tidak ditemukan
            //     abort(404);
            // }

            if (request()->ajax()) {
                $query = TransactionWifiItem::with(['product','wifis'])->where('transaction_wifi_id', $transaction->id);

                return DataTables::of($query)
                    ->editColumn('product.price', function ($item) {
                        return number_format($item->product->price);
                    })
                    ->editColumn('payment_status', function ($item) {
                        if ($item->payment_status == 'PAID') {
                            return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    ' . 'Sudah Dibayar'.'
                                </span>
                            </td>
                        ';
                        } elseif ($item->payment_status == 'UNPAID') {
                            return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                    ' . 'Belum Dibayar'.'
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
                    ->editColumn('description', function ($item) {
                        if ($item->description == true) {
                            return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight ">
                                    ' . $item->description . '
                                </span>
                            </td>
                        ';
                        } elseif ($item->description == null) {
                            return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight ">
                                    Tidak ada Catatan...
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
                ->rawColumns(['payment_status','description','product.price'])
                ->make();
            }

            return view('pages.customer.pembayaran_wifi_bulan.show', compact('transaction'));
        } catch (DecryptException $e) {
            return redirect()->route('landingPage.index')->with('error', 'Terjadi kesalahan dalam menampilkan transaksi');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
