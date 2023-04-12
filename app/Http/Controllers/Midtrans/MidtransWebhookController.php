<?php

namespace App\Http\Controllers\Midtrans;

use Midtrans\Snap;
use Midtrans\Config;
use GuzzleHttp\Client;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\SnapPreferences;
use App\Models\TransactionItem;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

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
            'order_id' => $transaction->id,
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

        // Cek apakah transaksi ditemukan dalam database berdasarkan order_id
        $transaction = Transaction::where('id', $request->order_id)->first();
        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        if ($request->status_code == 200) {
            if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
                $transaction->status = 'SUCCESS';
                $transaction->payment = 'Bank Transfer';
            } elseif ($request->transaction_status == 'pending') {
                $transaction->status = 'PENDING';
            } elseif ($request->transaction_status == 'deny') {
                $transaction->status = 'DENY';
                $transaction->payment = 'Bank Transfer';
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

        // return redirect()->route('dashboard.transaction.indexSuccess');
        return redirect()->route('dashboard.midtrans.show', $transaction->id);
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

    public function show(Transaction $transaction)
    {
        if (request()->ajax()) {
            $query = TransactionItem::with(['product'])->where('transactions_id', $transaction->id);

            return DataTables::of($query)
                ->editColumn('product.price', function ($item) {
                    return number_format($item->product->price);
                })
                ->make();
        }

        return view('pages.midtrans.index', compact('transaction'));
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
