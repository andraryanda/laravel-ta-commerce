<?php

namespace App\Http\Controllers\API;

use Midtrans\Snap;
use App\Models\User;
use Midtrans\Config;
use Ramsey\Uuid\Uuid;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\NotificationTransaction;
use App\Notifications\TransactionNotification;

class TransactionController extends Controller
{
    // public function all(Request $request)
    // {
    //     $id = $request->input('id');
    //     $limit = $request->input('limit', 6);
    //     $status = $request->input('status');

    //     if ($id) {
    //         $transaction = Transaction::with(['items.product'])->find($id)->orderBy('created_at', 'desc');

    //         if ($transaction)
    //             return ResponseFormatter::success(
    //                 $transaction,
    //                 'Data transaksi berhasil diambil'
    //             );
    //         else
    //             return ResponseFormatter::error(
    //                 null,
    //                 'Data transaksi tidak ada',
    //                 404
    //             );
    //     }

    //     $transaction = Transaction::with(['items.product.galleries', 'items.product.category'])->where('users_id', Auth::user()->id)->orderBy('created_at', 'desc');

    //     if ($status)
    //         $transaction->where('status', $status);

    //     return ResponseFormatter::success(
    //         $transaction->paginate($limit),
    //         'Data list transaksi berhasil diambil'
    //     );
    // }

    // public function all(Request $request)
    // {
    //     $id = $request->input('id');
    //     $limit = $request->input('limit', 6);
    //     $status = $request->input('status');

    //     if ($id) {
    //         $transaction = Transaction::with(['items.product'])->find($id)->orderBy('created_at', 'desc');

    //         if ($transaction)
    //             return ResponseFormatter::success(
    //                 $transaction,
    //                 'Data transaksi berhasil diambil'
    //             );
    //         else
    //             return ResponseFormatter::error(
    //                 null,
    //                 'Data transaksi tidak ada',
    //                 404
    //             );
    //     }

    //     $transaction = Transaction::with(['items.product.galleries', 'items.product.category'])->where('users_id', Auth::user()->id)->orderBy('created_at', 'desc');

    //     if ($status)
    //         $transaction->where('status', $status);

    //     return ResponseFormatter::success(
    //         $transaction->paginate($limit),
    //         'Data list transaksi berhasil diambil'
    //     );
    // }

    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $status = $request->input('status');

        if ($id) {
            $transaction = Transaction::with(['items.product'])->find($id)->orderBy('created_at', 'desc');

            if ($transaction)
                return ResponseFormatter::success(
                    $transaction,
                    'Data transaksi berhasil diambil'
                );
            else
                return ResponseFormatter::error(
                    null,
                    'Data transaksi tidak ada',
                    404
                );
        }

        $transaction = Transaction::with(['items.product.galleries', 'items.product.category'])->where('users_id', Auth::user()->id)->orderBy('created_at', 'desc');

        if ($status)
            $transaction->where('status', $status);

        $transactions = $transaction->paginate($limit);

        // Tambahkan snap_token dan snap_url ke setiap transaksi
        foreach ($transactions as $transaction) {
            $snapTokenData = $this->createSnapToken($transaction->id);
            $transaction->snap_token_midtrans = $snapTokenData['snap_token_midtrans'];
            $transaction->snap_url = $snapTokenData['snap_url'];
        }

        return ResponseFormatter::success(
            $transactions,
            'Data list transaksi berhasil diambil'
        );
    }

    public function createSnapToken($transactionId)
    {
        $transaction = Transaction::find($transactionId);

        if (!$transaction) {
            return [
                'snap_token_midtrans' => null,
                'snap_url' => null,
            ];
        }

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_ENVIRONMENT') === 'production' ? true : false;
        Config::$isSanitized = true;
        Config::$is3ds = false;

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

        try {
            $snap_token = Snap::createTransaction($transaction_data)->token;
        } catch (\Exception $e) {
            return [
                'snap_token_midtrans' => null,
                'snap_url' => null,
            ];
        }

        return [
            'snap_token_midtrans' => $snap_token,
            'snap_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snap_token,
        ];
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    // public function checkout(Request $request)
    // {
    //     $request->validate([
    //         'items' => 'required|array',
    //         'items.*.id' => 'exists:products,id',
    //         'total_price' => 'required',
    //         'shipping_price' => 'required',
    //         'status' => 'required|in:PENDING,SUCCESS,CANCELLED,FAILED,SHIPPING,SHIPPED',
    //     ]);

    //     // Mendapatkan nilai incre_id terakhir
    //     $lastTransaction = Transaction::orderBy('incre_id', 'desc')->first();

    //     // Mengisi nilai incre_id baru pada transaksi yang akan dibuat
    //     $increId = $lastTransaction ? $lastTransaction->incre_id + 1 : 1;

    //     $transaction = Transaction::create([
    //         // 'id' => Uuid::uuid4()->getHex(),
    //         'id' => Transaction::generateTransactionId(),
    //         'incre_id' => $increId, // Mengisi nilai incre_id
    //         'users_id' => Auth::user()->id,
    //         'address' => $request->address,
    //         'total_price' => $request->total_price,
    //         'shipping_price' => $request->shipping_price,
    //         'status' => $request->status,
    //     ]);

    //     foreach ($request->items as $product) {
    //         TransactionItem::create([
    //             // 'id' => Uuid::uuid4()->getHex(),
    //             'id' => Transaction::generateTransactionId(),
    //             'incre_id' => $increId, // Mengisi nilai incre_id
    //             'users_id' => Auth::user()->id,
    //             'products_id' => $product['id'],
    //             'transactions_id' => $transaction->id,
    //             'quantity' => $product['quantity']
    //         ]);
    //     }

    //     NotificationTransaction::create([
    //         // 'transactions_id' => $transaction->incre_id
    //         'transactions_id' => $transaction->id
    //     ]);

    //     // Get the transaction and user data
    //     $transaction = Transaction::find($transaction->id);
    //     $user = Auth::user();

    //     // Send the email
    //     Mail::to('andraryandra38@gmail.com')->send(new TransactionNotification($transaction, $user));

    //     // return ResponseFormatter::success($transaction->load('items.product'), 'Transaksi berhasil');
    //     return ResponseFormatter::success(
    //         $transaction->load('items.product'),
    //         'Transaksi berhasil',
    //         200,
    //     );
    // }
    // // return redirect()->route('dashboard.payment', ['id' => $transaction->id])->withSuccess('Transaksi berhasil ditambahkan!');


    // public function getTransaction(Request $request)
    // {
    //     $transactionId = $request->input('transaction_id');
    //     $transaction = Transaction::findOrFail($transactionId);

    //     return response()->json([
    //         'status' => 'success',
    //         'transaction' => $transaction,
    //     ]);
    // }


    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'exists:products,id',
            'total_price' => 'required',
            'shipping_price' => 'required',
            'status' => 'required|in:PENDING,SUCCESS,CANCELLED,FAILED,SHIPPING,SHIPPED',
        ]);

        // Mendapatkan nilai incre_id terakhir
        $lastTransaction = Transaction::orderBy('incre_id', 'desc')->first();

        // Mengisi nilai incre_id baru pada transaksi yang akan dibuat
        $increId = $lastTransaction ? $lastTransaction->incre_id + 1 : 1;

        $transaction = Transaction::create([
            // 'id' => Uuid::uuid4()->getHex(),
            'id' => Transaction::generateTransactionId(),
            'incre_id' => $increId, // Mengisi nilai incre_id
            'users_id' => Auth::user()->id,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'shipping_price' => $request->shipping_price,
            'status' => $request->status,
        ]);

        foreach ($request->items as $product) {
            TransactionItem::create([
                // 'id' => Uuid::uuid4()->getHex(),
                'id' => Transaction::generateTransactionId(),
                'incre_id' => $increId, // Mengisi nilai incre_id
                'users_id' => Auth::user()->id,
                'products_id' => $product['id'],
                'transactions_id' => $transaction->id,
                'quantity' => $product['quantity']
            ]);
        }

        NotificationTransaction::create([
            // 'transactions_id' => $transaction->incre_id
            'transactions_id' => $transaction->id
        ]);

        // Get the transaction and user data
        $transaction = Transaction::find($transaction->id);
        $user = Auth::user();

        // Send the email
        Mail::to('andraryandra38@gmail.com')->send(new TransactionNotification($transaction, $user));

        // Generate Snap Token
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

        try {
            $snap_token = Snap::createTransaction($transaction_data)->token;
        } catch (\Exception $e) {
            // Jika terjadi error, kirim response error dalam format JSON
            $response_data = [
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ];
            return response()->json($response_data, 500); // Menggunakan kode status HTTP 500 untuk error
        }

        // Simpan snap_token ke dalam model Transaction
        // $transaction->snap_token = $snap_token;
        // $transaction->save();

        // return ResponseFormatter::success($transaction->load('items.product'), 'Transaksi berhasil');
        return ResponseFormatter::success(
            $transaction->load('items.product'),
            'Transaksi berhasil',
            200,
        );
        // return ResponseFormatter::success(
        //     ['snap_token' => $snap_token],
        //     'Snap token berhasil dibuat',
        //     200,
        // );
    }
}
