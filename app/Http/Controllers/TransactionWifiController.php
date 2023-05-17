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
use App\Notifications\TransactionWifiNotification;
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
                    <div class="flex justify-start items-center space-x-3.5">
                        <a href="' . route('dashboard.bulan.sendWifiMessage', $item->id) . '" title="WhatsApp" target="_blank"
                            class="inline-flex flex-col items-center justify-center w-20 h-12 bg-green-400 text-white rounded-md border border-green-500 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">WhatsApp</p>
                        </a>
                        <a href="'. route('dashboard.midtrans.paymentWifi', $item->id) .'" target="_blank" title="Bayar"
                            class="flex flex-col shadow-sm items-center justify-center w-20 h-12 border border-purple-500 bg-purple-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-purple-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/credit-card.png') . '" alt="Bayar" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Bayar Wifi</p>
                        </a>
                        <a href="' . route('dashboard.bulan.show', $encryptedId) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                        <a href="' . route('dashboard.bulan.edit', $item->id) . '" title="Edit"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Edit</p>
                        </a>
                    </div>
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
            $transactions = Transaction::with(['user','wifi_items'])->get();

            $status_wifi = [
                ['label' => 'Aktif', 'value' => 'ACTIVE'],
                ['label' => 'Tidak Aktif', 'value' => 'INACTIVE'],
            ];

            $status_payment = [
                ['label' => 'PAID', 'value' => 'PAID'],
                ['label' => 'UNPAID', 'value' => 'UNPAID'],
            ];

            $status_payment_method = [
                ['label' => 'BANK TRANSFER', 'value' => 'BANK TRANSFER'],
                ['label' => 'MANUAL', 'value' => 'MANUAL'],
            ];

            // Pengecekan data
        if ($users->isEmpty()) {
            throw new \Exception('Tidak ada data pengguna (users)');
        }

        if ($transactions->isEmpty()) {
            throw new \Exception('Tidak ada data transaksi utama (transactions)');
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
                'status_payment_method',
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
                'payment_method' => $request->payment_method,
                'description' => $request->description,
            ]);

            DB::commit();

            $transactionWifi = TransactionWifi::find($transactionWifi->id);
            $user = Auth::user();

            Mail::to('andraryandra38@gmail.com')->send(new TransactionWifiNotification($transactionWifi, $user));

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

    public function sendWifiMessage(TransactionWifi $transactionWifi)
    {
        $phone_number = '+62' . substr_replace($transactionWifi->user->phone, '', 0, 1);

        $transaction_id = $transactionWifi->id;

        $items = TransactionWifiItem::with('product')
            ->where('transaction_wifi_id', $transaction_id)
            ->get();

        $total = 0;
        foreach ($items as $item) {
            $total += $item->product->price * $item->quantity;
        }

        $message = "Halo " . '*' . 'Admin' . '*' . ", saya ingin melakukan pembayaran Manual. Berikut adalah detail pesanan:\n\n";
        $message .= "-----------------------------------\n";
        $message .= "*Detail User:*\n";
        $message .= "*Nama       : "  . $transactionWifi->user->name . "*\n";
        $message .= "*Email        : "  . $transactionWifi->user->email . "*\n";
        $message .= "*Phone      : "  . $transactionWifi->user->phone . "*\n";
        $message .= "*Alamat     : "  . $transactionWifi->user->address . "*\n\n";

        $message .= "*Pesanan WiFi:*\n";
        // foreach ($items as $item) {
        //     $message .= "*Nama WiFi       : "  . $item->product->name . "*\n";
        //     $message .= "*Qty                        : "  . $item->quantity . "*\n";
        //     $message .= "*Harga WiFi       : Rp "  . number_format($item->product->price, 0, '.', ',') . "*\n";
        //     $message .= "*Subtotal                : Rp "  . number_format($item->product->price * $item->quantity, 0, '.', ',') . "*\n\n";
        // }
        // $message .= "*Total pembayaran : Rp "  . number_format($total, 0, '.', ',') . "*\n";
        // $message .= "*Status pesanan      : "  . $transactionWifi->status . "*\n\n";
        $message .= "-----------------------------------\n\n";

        if ($transactionWifi->status == 'ACTIVE') {
            $message .= "WiFi telah diaktifkan. Anda dapat menggunakan WiFi sekarang. Terima kasih!\n";
            $message .= "Silakan hubungi kami jika Anda memiliki pertanyaan atau masukan.\n";
            $message .= "*Al's Store: 085314005779*";
        } else if ($transactionWifi->status == 'INACTIVE') {
            $message .= "WiFi tidak aktif. Silakan hubungi kami jika Anda memiliki pertanyaan atau masukan.\n\n";
            $message .= "*Al's Store: 085314005779*";
        }

        $url = 'https://wa.me/' . $phone_number . '?text=' . urlencode($message);
        return redirect()->away($url);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $users = User::where('roles', '=', 'USER')->get();
            $products = Product::with('galleries')->with('category')->get();
            $transactions = Transaction::with(['user', 'wifi_items'])->get();

            $status_wifi = [
                ['label' => 'Aktif', 'value' => 'ACTIVE'],
                ['label' => 'Tidak Aktif', 'value' => 'INACTIVE'],
            ];

            $status_payment = [
                ['label' => 'PAID', 'value' => 'PAID'],
                ['label' => 'UNPAID', 'value' => 'UNPAID'],
            ];

            $status_payment_method = [
                ['label' => 'BANK TRANSFER', 'value' => 'BANK TRANSFER'],
                ['label' => 'MANUAL', 'value' => 'MANUAL'],
            ];

            // Retrieve the transaction wifi by ID
            $transactionWifi = TransactionWifi::with('wifi_items')->findOrFail($id);

            return view('pages.dashboard.pembayaran_wifi_bulan.edit', compact(
                'transactionWifi',
                'products',
                'users',
                'transactions',
                'status_wifi',
                'status_payment',
                'status_payment_method',
            ));
        } catch (\Exception $e) {
            // Handle errors here
            // For example, display an error message or redirect to another page
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionWifiRequest $validatedData, $id)
    {
        try {
            // Validate the request data
            // $validatedData = $request->validate([
            //     'users_id' => 'required',
            //     'products_id' => 'required',
            //     'transactions_id' => 'required',
            //     'total_price_wifi' => 'required',
            //     'status' => 'required',
            //     'expired_wifi' => 'required',
            //     'payment_status' => 'required',
            //     'payment_transaction' => 'required',
            //     'payment_method' => 'required',
            //     'description' => 'nullable',
            // ]);

            // Find the transaction wifi by ID
            $transactionWifi = TransactionWifi::findOrFail($id);

            // Update the transaction wifi
            $transactionWifi->update([
                'users_id' => $validatedData['users_id'],
                'products_id' => $validatedData['products_id'],
                'transactions_id' => $validatedData['transactions_id'],
                'total_price_wifi' => $validatedData['total_price_wifi'],
                'status' => $validatedData['status'],
                'expired_wifi' => $validatedData['expired_wifi'],
            ]);

            // Find the transaction wifi item by ID
            $transactionWifiItem = TransactionWifiItem::where('transaction_wifi_id', $id)->first();

            // Update the transaction wifi item
            $transactionWifiItem->update([
                'users_id' => $transactionWifi->users_id,
                'products_id' => $transactionWifi->products_id,
                'transaction_wifi_id' => $transactionWifi->id,
                'payment_status' => $validatedData['payment_status'],
                'payment_transaction' => $validatedData['payment_transaction'],
                'payment_method' => $validatedData['payment_method'],
                'description' => $validatedData['description'],
            ]);

            // Redirect or return a response
            return redirect()->route('dashboard.bulan.index')->withSuccess('Transaction Wifi updated successfully');
        } catch (\Exception $e) {
        //     // Handle errors here
        //     // For example, display an error message or redirect to another page
            return redirect()->back()->withError('Terjadi kesalahan: ' . $e->getMessage());
        }
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
