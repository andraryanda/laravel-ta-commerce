<?php

namespace App\Http\Controllers\Midtrans;

use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;
use GuzzleHttp\Client;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\SnapPreferences;
use App\Models\TransactionItem;
use App\Models\TransactionWifi;
use App\Http\Middleware\IsAdmin;
use App\Models\TransactionWifiItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\TransactionSuccessNotification;
use Illuminate\Contracts\Encryption\DecryptException;

class MidtransWebhookController extends Controller
{

    public function cancelPayment($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Set konfigurasi midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_ENVIRONMENT') === 'production' ? true : false;
        Config::$isSanitized = true;
        Config::$is3ds = false;

        // Panggil API midtrans untuk membatalkan transaksi
        try {
            $midtrans_transaction = Transaction::status($transaction->midtrans_transaction_id);
            $midtrans_transaction->cancel();
            $transaction->status = 'CANCELLED';
            $transaction->save();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => $e->getMessage()]);
        }

        return redirect()->route('dashboard.midtrans.show', $id)->withError('Transaksi telah dibatalkan.');
    }


    public function paymentWifi($id)
    {
        $transaction = TransactionWifi::with(['user', 'product'])->findOrFail($id);

        // Set konfigurasi midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_ENVIRONMENT') === 'production' ? true : false;
        Config::$isSanitized = true;
        Config::$is3ds = false;

        // Buat array untuk data pembayaran
        $transaction_details = [
            'order_id' => $transaction->id . '_' . time(), // Tambahkan timestamp ke order ID
            'gross_amount' => $transaction->total_price_wifi,
        ];

        // $items = [];
        // foreach ($transaction->wifi_items as $item) {
        //     $items[] = [
        //         'id' => $item->id,
        //         'price' => $item->product->price,
        //         'quantity' => 1,
        //         'name' => $item->product->name,
        //     ];
        // }

        $items = [
            [
                'id' => $transaction->id,
                'price' => $transaction->total_price_wifi,
                'quantity' => 1,
                'name' => $transaction->product->name
            ],
        ];


        // Buat array untuk data pembelian
        $transaction_data = [
            'transaction_details' => $transaction_details,
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'name' => $transaction->user->name,
                'email' => $transaction->user->email,
                'phone' => $transaction->user->phone,
            ],
            'callbacks' => [
                'finish' => route('dashboard.payment.finish', $transaction->id),
                'back_button' => [
                    'url' => route('dashboard.midtrans.cancel', $transaction->id),
                ],
                'unfinish' => route('dashboard.payment.unfinish', $transaction->id),
            ],
        ];

        // Panggil API midtrans untuk membuat transaksi baru
        try {
            $snap_token = Snap::createTransaction($transaction_data)->token;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => $e->getMessage()]);
        }
        // Redirect ke halaman pembayaran
        return redirect()->away('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snap_token)
            ->with(['transaction_id' => $transaction->id]);
    }


    public function payment($id)
    {
        $transaction = Transaction::with('user')->findOrFail($id);

        // Set konfigurasi midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_ENVIRONMENT') === 'production' ? true : false;
        Config::$isSanitized = true;
        Config::$is3ds = false;

        // Buat array untuk data pembayaran
        $transaction_details = [
            'order_id' => $transaction->id . '_' . time(),
            'gross_amount' => $transaction->total_price + $transaction->shipping_price,
        ];

        // Buat array untuk item pembelian
        $items = [];
        foreach ($transaction->items as $item) {
            $items[] = [
                'id' => $item->id,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'name' => $item->product->name,
            ];
        }

        // Buat array untuk data pembelian
        $transaction_data = [
            'transaction_details' => $transaction_details,
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'name' => $transaction->user->name,
                'email' => $transaction->user->email,
                'phone' => $transaction->user->phone,
                'address' => [
                    'address' => $transaction->address,
                ],
            ],
            'callbacks' => [
                'finish' => route('dashboard.payment.finish', $transaction->id),
                'back_button' => [
                    'url' => route('dashboard.midtrans.cancel', $transaction->id),
                ],
                'unfinish' => route('dashboard.payment.unfinish', $transaction->id),
            ],
        ];

        // Panggil API midtrans untuk membuat transaksi baru
        try {
            $snap_token = Snap::createTransaction($transaction_data)->token;
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['msg' => $e->getMessage()]);
        }
        // Redirect ke halaman pembayaran
        return redirect()->away('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snap_token)
            ->with(['transaction_id' => $transaction->id]);
    }

    //Payment Notification URL*
    public function notification(Request $request)
    {
        // Set your server key from config file or env
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = !env('MIDTRANS_IS_SANDBOX');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $notif = new Notification();

        $transaction = Transaction::where('id', $notif->order_id)->firstOrFail();

        // Handle notification status
        switch ($notif->transaction_status) {
            case 'capture':
                if ($notif->fraud_status == 'challenge') {
                    // Handle if payment is challenged
                    $transaction->status = 'CHALLENGE';
                    $transaction->save();
                } else if ($notif->fraud_status == 'accept') {
                    // Handle if payment is accepted
                    $transaction->status = 'SUCCESS';
                    $transaction->save();
                }
                break;
            case 'settlement':
                // Handle if payment is settled
                $transaction->status = 'SUCCESS';
                $transaction->save();
                break;
            case 'deny':
                // Handle if payment is denied
                $transaction->status = 'DENY';
                $transaction->save();
                break;
            case 'expire':
                // Handle if payment is expired
                $transaction->status = 'EXPIRED';
                $transaction->save();
                break;
            case 'cancel':
                // Handle if payment is canceled
                $transaction->status = 'CANCELLED';
                $transaction->save();
                break;
            case 'pending':
                // Handle if payment is pending
                $transaction->status = 'PENDING';
                $transaction->save();
                break;
            default:
                // Handle if transaction status is unknown
                $transaction->status = 'UNKNOWN';
                $transaction->save();
                break;
        }

        return response()->json(['success' => true]);
    }

    //Recurring Notification URL*
    public function notificationHandler(Request $request)
    {
        // Set your server key from config file or env
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = !env('MIDTRANS_IS_SANDBOX');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Get transaction data from the request
        $transaction = Transaction::where('id', $request->order_id)->firstOrFail();

        // Handle the notification
        $notification = new Notification();

        switch ($notification->transaction_status) {
            case 'capture':
                if ($notification->fraud_status == 'challenge') {
                    $transaction->status = 'PENDING';
                } else if ($notification->fraud_status == 'accept') {
                    $transaction->status = 'SUCCESS';
                }
                break;
            case 'settlement':
                $transaction->status = 'SUCCESS';
                break;
            case 'deny':
                $transaction->status = 'DENY';
                break;
            case 'expire':
                $transaction->status = 'EXPIRED';
                break;
            case 'cancel':
                $transaction->status = 'CANCELLED';
                break;
            default:
                $transaction->status = 'FAILED';
                break;
        }

        $transaction->save();

        return response()->json([
            'status' => 'OK',
        ]);
    }

    //Pay Account Notification URL*
    public function handlePayAccountNotification(Request $request)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = !env('MIDTRANS_IS_SANDBOX');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $notif = new Notification();

        // Assign variable from notification data
        $transactionStatus = $notif->transaction_status;
        $fraudStatus = $notif->fraud_status;
        $orderId = $notif->order_id;

        // Find transaction by order_id
        $transaction = Transaction::where('id', $orderId)->firstOrFail();

        // Update transaction status
        $transaction->status = $transactionStatus;
        $transaction->save();

        return response()->json([
            'status' => 'OK'
        ]);
    }

    public function handlefinish(Request $request)
    {
        // Set your server key from config file or env
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = !env('MIDTRANS_IS_SANDBOX');
        Config::$isSanitized = true;
        Config::$is3ds = true;


        $order_id_parts = explode('_', $request->order_id);
        $order_id_time = $order_id_parts[0]; // Ambil ID transaksi saja, tanpa timestamp


        // Cek apakah transaksi ditemukan dalam database berdasarkan order_id
        // $transaction = Transaction::where('id', $request->order_id)->first();
        $transaction = Transaction::where('id', $order_id_time)->first();
        // $transactionWifi = TransactionWifi::with(['wifi_items'])->where('id', $request->order_id)->first();
        $transactionWifi = TransactionWifi::with(['wifi_items'])->where('id', $order_id_time)->first();


        // if (!$transaction) {
        //     return response()->json(['error' => 'Transaction not found'], 404);
        // }

        if ($transaction) {
            // Transksi Pembelian Produk
            if ($request->status_code == 200) {
                if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
                    $transaction->status = 'SUCCESS';
                    $transaction->payment = 'Bank Transfer';
                } elseif ($request->transaction_status == 'pending') {
                    $transaction->status = 'PENDING';
                } elseif ($request->transaction_status == 'deny') {
                    $transaction->status = 'DENY';
                    // $transaction->payment = 'Bank Transfer';
                    // batalkan transaksi di Midtrans
                    \Midtrans\Transaction::cancel($request->order_id);
                } elseif ($request->transaction_status == 'expire') {
                    $transaction->status = 'EXPIRED';
                    $transaction->payment = 'Bank Transfer';
                    // batalkan transaksi di Midtrans
                    \Midtrans\Transaction::cancel($request->order_id);
                } elseif ($request->transaction_status == 'cancel') {
                    $transaction->status = 'CANCELLED';
                    $transaction->payment = 'Bank Transfer';
                    // batalkan transaksi di Midtrans
                    \Midtrans\Transaction::cancel($request->order_id);
                } else {
                    $transaction->status = 'CANCELLED';
                    $transaction->payment = 'Bank Transfer';
                    // batalkan transaksi di Midtrans
                    \Midtrans\Transaction::cancel($request->order_id);
                }
            } else {
                $transaction->status = 'CANCELLED';
                $transaction->payment = 'Bank Transfer';
                // batalkan transaksi di Midtrans
                \Midtrans\Transaction::cancel($request->order_id);
            }


            $transaction->save();

            // Get the transaction and user data
            $transaction = Transaction::find($transaction->id);
            $user = Auth::user();

            // Send the email
            Mail::to('andraryandra38@gmail.com')->send(new TransactionSuccessNotification($transaction, $user));

            if ($transaction) {
                // Mengambil nilai id dan users_id dari model Transaction
                $transactionId = $transaction->id;
                $userId = $transaction->users_id;

                // Logika pengalihan pengguna berdasarkan role dan nilai order_id
                if ($user->roles == 'USER' && $transaction->id . '_' . time() == $request->order_id && $transaction->users_id == $user->id) {
                    // Jika pengguna bukan admin dan order_id == request->order_id dan users_id == id pengguna
                    return redirect()->route('dashboard.midtrans.showCustomer', encrypt($transactionId));
                } else {
                    // Jika pengguna tidak memiliki peran admin atau kondisi lainnya ADMIN
                    return redirect()->route('dashboard.midtrans.show', encrypt($transactionId));
                }
            } else {
                // Logika jika data transaksi tidak ditemukan
                // Misalnya menampilkan pesan error atau mengarahkan pengguna ke halaman lain
                // ...
                return redirect()->route('landingPage.index')->withError('Transaksi Problem');
            }
        } elseif ($transactionWifi) {
            // Transaksi pembayaran wifi
            if ($request->status_code == 200) {
                if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
                    $transactionWifi->status = 'ACTIVE';

                    // Menambahkan data pada tabel transaction_wifi_items
                    $lastTransaction = TransactionWifiItem::orderBy('incre_id', 'desc')->first();
                    $increId = $lastTransaction ? $lastTransaction->incre_id + 1 : 1;

                    $transactionWifiItem = new TransactionWifiItem();
                    $transactionWifiItem->incre_id = $increId;
                    $transactionWifiItem->users_id = $transactionWifi->users_id;
                    $transactionWifiItem->products_id = $transactionWifi->products_id;
                    $transactionWifiItem->transaction_wifi_id = $transactionWifi->id;
                    // $transactionWifiItem->order_id = $transactionWifi->id;
                    $transactionWifiItem->payment_status = 'PAID';
                    $transactionWifiItem->payment_transaction = $transactionWifi->total_price_wifi;
                    $transactionWifiItem->payment_method = 'BANK TRANSFER';
                    $transactionWifiItem->payment_bank = 'MIDTRANS';
                    $transactionWifiItem->description = 'Pembayaran Lunas Wifi - Otomatis dari Customer ' . Carbon::now()->format('d-m-Y H:i:s');
                    $transactionWifiItem->created_at = now();
                    $transactionWifiItem->updated_at = now();
                    $transactionWifiItem->save();

                    // Menambahkan 1 bulan pada tanggal expired_wifi
                    $expiredWifi = Carbon::parse($transactionWifi->expired_wifi);
                    $newExpiredWifi = $expiredWifi->addMonth();
                    $transactionWifi->expired_wifi = $newExpiredWifi;
                    $transactionWifi->save();
                } elseif ($request->transaction_status == 'pending') {
                    $transactionWifi->status = 'INACTIVE';
                    foreach ($transactionWifi->wifi_items as $wifi_item) {
                        $wifi_item->payment_status = 'UNPAID';
                        $wifi_item->save();
                    }
                } elseif ($request->transaction_status == 'deny') {
                    $transactionWifi->status = 'INACTIVE';
                    foreach ($transactionWifi->wifi_items as $wifi_item) {
                        $wifi_item->payment_status = 'UNPAID';
                        $wifi_item->save();
                    }
                    // batalkan transaksi di Midtrans
                    \Midtrans\Transaction::cancel($request->order_id);
                } elseif ($request->transaction_status == 'expire') {
                    $transactionWifi->status = 'INACTIVE';
                    foreach ($transactionWifi->wifi_items as $wifi_item) {
                        $wifi_item->payment_status = 'UNPAID';
                        $wifi_item->save();
                    }
                    // batalkan transaksi di Midtrans
                    \Midtrans\Transaction::cancel($request->order_id);
                } elseif ($request->transaction_status == 'cancel') {
                    $transactionWifi->status = 'INACTIVE';
                    foreach ($transactionWifi->wifi_items as $wifi_item) {
                        $wifi_item->payment_status = 'UNPAID';
                        $wifi_item->save();
                    }
                    // batalkan transaksi di Midtrans
                    \Midtrans\Transaction::cancel($request->order_id);
                } else {
                    $transactionWifi->status = 'INACTIVE';
                    foreach ($transactionWifi->wifi_items as $wifi_item) {
                        $wifi_item->payment_status = 'UNPAID';
                        $wifi_item->save();
                    }
                    // batalkan transaksi di Midtrans
                    \Midtrans\Transaction::cancel($request->order_id);
                }
            } else {
                $transactionWifi->status = 'INACTIVE';
                foreach ($transactionWifi->wifi_items as $wifi_item) {
                    $wifi_item->payment_status = 'UNPAID';
                    $wifi_item->save();
                }
                // batalkan transaksi di Midtrans
                \Midtrans\Transaction::cancel($request->order_id);
            }

            $transactionWifi->save();

            // Get the transactionWifi and user data
            $transactionWifi = TransactionWifi::find($transactionWifi->id);
            $user = Auth::user();

            // Send the email
            // Mail::to('andraryandra38@gmail.com')->send(new TransactionWifiSuccessNotification($transactionWifi, $user));

            if ($transactionWifi) {
                // Mengambil nilai id dan users_id dari model Transaction
                $transactionId = $transactionWifi->id;
                $userId = $transactionWifi->users_id;

                // Logika pengalihan pengguna berdasarkan role dan nilai order_id

                // if ($user->roles == 'USER' && $transactionWifi->id == $request->order_id && $transactionWifi->users_id == $user->id) {
                if ($user->roles == 'USER' && $transactionWifi->id . '_' . time() == $request->order_id && $transactionWifi->users_id == $user->id) { // Jika pengguna bukan admin dan order_id == request->order_id dan users_id == id pengguna
                    return redirect()->route('dashboard.bulan.showCustomerWifi1', encrypt($transactionId));
                    // return redirect()->route('dashboard.midtrans.showCustomerWifi', encrypt($transactionId));
                    // return redirect()->route('dashboard.bulan-customer.index')->withSuccess('Pembayaran Berhasil Dilakukan');
                } else {
                    // Jika pengguna tidak memiliki peran admin atau ko  ndisi lainnya ADMIN
                    return redirect()->route('dashboard.midtrans.showCustomerWifi', encrypt($transactionId));
                }
            } else {
                // Logika jika data transaksi tidak ditemukan
                // Misalnya menampilkan pesan error atau mengarahkan pengguna ke halaman lain
                // ...
                return redirect()->route('landingPage.index')->withError('Transaksi Problem');
            }
        }

        // return redirect()->route('dashboard.midtrans.show', encrypt($transaction->id));
    }



    public function handleUnfinish(Request $request)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = !env('MIDTRANS_IS_SANDBOX');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $transaction = Transaction::where('id', $request->order_id)->firstOrFail();

        $transaction->status = 'CANCELLED';
        $transaction->payment = 'Bank Transfer';
        $transaction->save();
        \Midtrans\Transaction::cancel($request->order_id);

        return redirect()->route('dashboard.midtrans.show', $transaction->id)->with('warning', 'Transaction is pending');
    }

    public function handleError(Request $request)
    {
        // Set your server key from config file or env
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = !env('MIDTRANS_IS_SANDBOX');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Check if transaction status is set to 'settlement'
        if ($request->input('transaction_status') == 'settlement') {
            // Payment success, redirect to Finish URL
            return redirect()->to(env('FINISH_REDIRECT_URL'));
        } else {
            // Payment failed, redirect to Error URL
            return redirect()->to(env('ERROR_REDIRECT_URL'));
        }
    }

    public function show($encryptedId)
    {

        try {
            $id = Crypt::decrypt($encryptedId); // Mendekripsi ID transaksi
            $transaction = Transaction::find($id);
            if (!$transaction) {
                // Lakukan penanganan jika transaksi tidak ditemukan
                abort(404);
            }

            // Verifikasi users_id sesuai dengan id pengguna yang sedang masuk
            // if ($transaction->users_id != auth()->user()->id) {
            //     return redirect()->route('dashboard.index')->with('error', 'Anda tidak memiliki akses ke transaksi ini');
            // }

            if (request()->ajax()) {
                $query = TransactionItem::with(['product'])->where('transactions_id', $transaction->id);

                return DataTables::of($query)
                    ->editColumn('product.price', function ($item) {
                        return number_format($item->product->price);
                    })
                    ->make();
            }

            return view('pages.midtrans.index', compact('transaction'));
        } catch (DecryptException $e) {
            return redirect()->route('dashboard.index')->with('error', 'Terjadi kesalahan dalam menampilkan transaksi');
        }
    }


    public function showCustomer($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId); // Mendekripsi ID transaksi
            $transaction = Transaction::find($id);
            if (!$transaction) {
                // Lakukan penanganan jika transaksi tidak ditemukan
                abort(404);
            }

            // // Verifikasi users_id sesuai dengan id pengguna yang sedang masuk
            // if ($transaction->users_id != auth()->user()->id) {
            //     return redirect()->route('landingPage.index')->withError('Anda tidak memiliki akses ke transaksi ini');
            // }

            if (request()->ajax()) {
                $query = TransactionItem::with(['product'])->where('transactions_id', $transaction->id);

                return DataTables::of($query)
                    ->editColumn('product.price', function ($item) {
                        return number_format($item->product->price);
                    })
                    ->make();
            }

            return view('pages.midtrans.indexCustomer', compact('transaction'));
        } catch (DecryptException $e) {
            return redirect()->route('dashboard.indexDashboardCustomer')->withError('Terjadi kesalahan dalam menampilkan transaksi');
        }
    }

    public function showCustomerWifi1($encryptedId)
    {

        try {
            $id = Crypt::decrypt($encryptedId); // Mendekripsi ID transaksi
            $transaction = TransactionWifi::with(['items'])->find($id);
            if (!$transaction) {
                // Lakukan penanganan jika transaksi tidak ditemukan
                abort(404);
            }

            // // Verifikasi users_id sesuai dengan id pengguna yang sedang masuk
            // if ($transaction->users_id != auth()->user()->id) {
            //     return redirect()->route('dashboard.index')->with('error', 'Anda tidak memiliki akses ke transaksi ini');
            // }

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
                                    ' . 'Sudah Dibayar' . '
                                </span>
                            </td>
                        ';
                        } elseif ($item->payment_status == 'UNPAID') {
                            return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                    ' . 'Belum Dibayar' . '
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
                    ->rawColumns(['payment_status', 'description'])
                    ->make();
            }

            return view('pages.midtrans.index2', compact('transaction'));
        } catch (DecryptException $e) {
            return redirect()->route('dashboard.index')->with('error', 'Terjadi kesalahan dalam menampilkan transaksi');
        }
    }

    public function showCustomerWifi($encryptedId)
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
                                    ' . 'Sudah Dibayar' . '
                                </span>
                            </td>
                        ';
                        } elseif ($item->payment_status == 'UNPAID') {
                            return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                    ' . 'Belum Dibayar' . '
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
                    ->rawColumns(['payment_status', 'description'])
                    ->make();
            }

            return view('pages.midtrans.indexCustomerWifi', compact('transaction'));
        } catch (DecryptException $e) {
            return redirect()->route('landingPage.index')->with('error', 'Terjadi kesalahan dalam menampilkan transaksi');
        }
    }
}



// public function updateStatus(Request $request)
// {
//     $transaction = Transaction::where('id', $request->order_id)->firstOrFail();

//     if ($request->status_code == 200) {
//         if ($request->transaction_status == 'settlement') {
//             $transaction->status = 'SUCCESS';
//         } elseif ($request->transaction_status == 'pending') {
//             $transaction->status = 'PENDING';
//         } elseif ($request->transaction_status == 'deny') {
//             $transaction->status = 'DENY';
//         } elseif ($request->transaction_status == 'expire') {
//             $transaction->status = 'EXPIRED';
//         } elseif ($request->transaction_status == 'cancel') {
//             $transaction->status = 'CANCELLED';
//         } else {
//             $transaction->status = 'CANCELLED';
//         }
//     } else {
//         $transaction->status = 'CANCELLED';
//     }

//     $transaction->save();
//     return redirect()->route('dashboard.transaction.show', $transaction->id);
// }
// // Cara update transaksi 2
// public function paymentFinish($id)
// {
//     $transaction = Transaction::findOrFail($id);
//     $transaction->status = 'SUCCESS';
//     $transaction->save();

//     return redirect()->route('dashboard.transaction.show', $id);
// }
