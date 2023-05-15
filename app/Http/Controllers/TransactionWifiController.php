<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use App\Models\TransactionWifi;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionWifiItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TransactionWifiRequest;
use App\Notifications\TransactionNotification;
use Illuminate\Contracts\Encryption\DecryptException;

class TransactionWifiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = TransactionWifi::with(['user','wifi_items.product'])
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
                    return '
                    <td class="px-4 py-3 text-xs">
                        <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                            ' . $item->status . '
                        </span>
                    </td>
                ';
                } elseif ($item->status == 'INACTIVE') {
                    return '
                    <td class="px-4 py-3 text-xs">
                        <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
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
                    <a href="' . route('dashboard.bulan.show', $encryptedId) . '" title="Show"
                        class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                        <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                        <p class="mt-1 text-xs">Lihat</p>
                    </a>
                   ';
                })
                ->rawColumns(['action','status','user.name'])
                ->make();
        }
        return view('pages.dashboard.pembayaran_wifi_bulan.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $users = User::where('roles', '=', 'USER')->get();
            $products = Product::with('galleries')->with('category')->get();
            $transactions = Transaction::with(['user'])->get();

            $status_wifi = [
                ['label' => 'Tersedia', 'value' => 'ACTIVE'],
                ['label' => 'Tidak Tersedia', 'value' => 'INACTIVE'],
            ];

            $status_payment = [
                ['label' => 'PAID', 'value' => 'PAID'],
                ['label' => 'UNPAID', 'value' => 'UNPAID'],
            ];

            // Pengecekan data
        if ($users->isEmpty()) {
            throw new \Exception('Tidak ada data pengguna (users)');
        }

        if ($products->isEmpty()) {
            throw new \Exception('Tidak ada data produk (products)');
        }


            return view('pages.dashboard.pembayaran_wifi_bulan.create', compact(
                'products',
                'users',
                'transactions',
                'status_wifi',
                'status_payment',
            ));
        } catch (\Exception $e) {
            // Tangani kesalahan di sini
            // Misalnya, tampilkan pesan kesalahan atau redirect ke halaman lain
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionWifiRequest $request)
    {
        $lastTransaction = TransactionWifi::orderBy('incre_id', 'desc')->first();

        $increId = $lastTransaction ? $lastTransaction->incre_id + 1 : 1;

        DB::beginTransaction();

        try {
            $transactionWifi = TransactionWifi::create([
                'id' => TransactionWifi::generateTransactionId(),
                'incre_id' => $increId,
                'users_id' => $request->users_id,
                'products_id' => $request->products_id,
                'transactions_id' => $request->transactions_id,
                'total_price_wifi' => $request->total_price_wifi,
                'status' => $request->status,
                'expired_wifi' => $request->expired_wifi,
            ]);

            TransactionWifiItem::create([
                'id' => TransactionWifi::generateTransactionId(),
                'incre_id' => $increId,
                'users_id' => $transactionWifi->users_id,
                'products_id' => $transactionWifi->products_id,
                'transaction_wifi_id' => $transactionWifi->id,
                'payment_status' => $request->payment_status,
                'payment_transaction' => $request->payment_transaction,
                'description' => $request->description,
            ]);

            // NotificationTransaction::create([
            //     // 'transactions_id' => $transaction->incre_id
            //     'transactions_id' => $transaction->id
            // ]);

            DB::commit();

            // $transactionWifi = TransactionWifi::find($transactionWifi->id);
            // $user = Auth::user();

            // Mail::to('andraryandra38@gmail.com')->send(new TransactionNotification($transactionWifi, $user));

            return redirect()->route('dashboard.bulan.index')->withSuccess('Transaksi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['message' => 'Terjadi kesalahan saat membuat transaksi.']);
        }
    }

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
            $transaction = TransactionWifi::with(['items'])->find($id);
            if (!$transaction) {
                // Lakukan penanganan jika transaksi tidak ditemukan
                abort(404);
            }

            if (request()->ajax()) {
                $query = TransactionWifiItem::with(['product'])->where('transaction_wifi_id', $transaction->id);

                return DataTables::of($query)
                    ->editColumn('product.price', function ($item) {
                        return number_format($item->product->price);
                    })
                    ->editColumn('payment_status', function ($item) {
                        if ($item->payment_status == 'PAID') {
                            return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    ' . $item->payment_status . '
                                </span>
                            </td>
                        ';
                        } elseif ($item->payment_status == 'UNPAID') {
                            return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                    ' . $item->payment_status . '
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
                ->rawColumns(['payment_status','description'])
                ->make();
            }

            return view('pages.dashboard.pembayaran_wifi_bulan.show', compact('transaction'));
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
