<?php

namespace App\Http\Controllers\API\MidtransAPI;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class MidtransAPIWebhookController extends Controller
{
    // public function payment($id)
    // {
    //     $transaction = Transaction::with('user')->findOrFail($id);

    //     // Set konfigurasi midtrans
    //     Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    //     Config::$isProduction = env('MIDTRANS_ENVIRONMENT') === 'production' ? true : false;
    //     Config::$isSanitized = true;
    //     Config::$is3ds = false;

    //     // Buat array untuk data pembayaran
    //     $transaction_details = [
    //         'order_id' => $transaction->id,
    //         'gross_amount' => $transaction->total_price + $transaction->shipping_price,
    //     ];

    //     // Buat array untuk item pembelian
    //     $items = [];
    //     foreach ($transaction->items as $item) {
    //         $items[] = [
    //             'id' => $item->id,
    //             'price' => $item->product->price,
    //             'quantity' => $item->quantity,
    //             'name' => $item->product->name,
    //         ];
    //     }

    //     // Buat array untuk data pembelian
    //     $transaction_data = [
    //         'transaction_details' => $transaction_details,
    //         'item_details' => $items,
    //         'customer_details' => [
    //             'first_name' => $transaction->user->name,
    //             'name' => $transaction->user->name,
    //             'email' => $transaction->user->email,
    //             'phone' => $transaction->user->phone,
    //             'address' => [
    //                 'address' => $transaction->address,
    //             ],
    //         ],
    //         'callbacks' => [
    //             'finish' => route('dashboard.payment.finish', $transaction->id),
    //             'back_button' => [
    //                 'url' => route('dashboard.midtrans.cancel', $transaction->id),
    //             ],
    //             'unfinish' => route('dashboard.payment.unfinish', $transaction->id),
    //         ],
    //     ];

    //     // Panggil API midtrans untuk membuat transaksi baru
    //     try {
    //         $snap_token = Snap::createTransaction($transaction_data)->token;
    //     } catch (\Exception $e) {
    //         // Jika terjadi error, kirim response error dalam format JSON
    //         $response_data = [
    //             'status' => 'error',
    //             'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
    //         ];
    //         return response()->json($response_data, 500); // Menggunakan kode status HTTP 500 untuk error
    //     }

    //     // Redirect pengguna ke halaman pembayaran Midtrans
    //     return redirect()->away('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snap_token)
    //         ->with(['transaction_id' => $transaction->id]);

    //     // Kembalikan token pembayaran sebagai response JSON
    //     return response()->json([
    //         'status' => 'success',
    //         'token' => $snap_token,
    //         'transaction_id' => $transaction->id,
    //     ]);
    // }

    public function payment($id, Request $request)
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
            // Jika terjadi error, kirim response error dalam format JSON
            $response_data = [
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ];
            return response()->json($response_data, 500); // Menggunakan kode status HTTP 500 untuk error
        }

        // Cek jika request berasal dari API
        if ($request->wantsJson()) {
            // Kembalikan token pembayaran sebagai response JSON
            return response()->json([
                'status' => 'success',
                'token' => $snap_token,
                'transaction_id' => $transaction->id,
            ]);
        } else {
            // Redirect pengguna ke halaman pembayaran Midtrans
            return redirect()->away('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snap_token)
                ->with(['transaction_id' => $transaction->id]);
        }
    }


    // public function payment($id)
    // {
    //     $transaction = Transaction::with('user')->findOrFail($id);

    //     // Set konfigurasi Midtrans
    //     Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    //     Config::$isProduction = env('MIDTRANS_ENVIRONMENT') === 'production' ? true : false;
    //     Config::$isSanitized = true;
    //     Config::$is3ds = false;

    //     // Buat array untuk data pembayaran
    //     $transaction_details = [
    //         'order_id' => $transaction->id,
    //         'gross_amount' => $transaction->total_price + $transaction->shipping_price,
    //     ];

    //     // Buat array untuk item pembelian
    //     $items = [];
    //     foreach ($transaction->items as $item) {
    //         $items[] = [
    //             'id' => $item->id,
    //             'price' => $item->product->price,
    //             'quantity' => $item->quantity,
    //             'name' => $item->product->name,
    //         ];
    //     }

    //     // Buat array untuk data pembelian
    //     $transaction_data = [
    //         'transaction_details' => $transaction_details,
    //         'item_details' => $items,
    //         'customer_details' => [
    //             'first_name' => $transaction->user->name,
    //             'name' => $transaction->user->name,
    //             'email' => $transaction->user->email,
    //             'phone' => $transaction->user->phone,
    //             'address' => [
    //                 'address' => $transaction->address,
    //             ],
    //         ],
    //         'callbacks' => [
    //             'finish' => route('dashboard.payment.finish', $transaction->id),
    //             'back_button' => [
    //                 'url' => route('dashboard.midtrans.cancel', $transaction->id),
    //             ],
    //             'unfinish' => route('dashboard.payment.unfinish', $transaction->id),
    //         ],
    //     ];

    //     // Panggil API Midtrans untuk membuat transaksi baru
    //     try {
    //         $snap_token = Snap::createTransaction($transaction_data)->token;
    //     } catch (\Exception $e) {
    //         // Jika terjadi error, kirim response error dalam format JSON
    //         $response_data = [
    //             'status' => 'error',
    //             'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
    //         ];
    //         return response()->json($response_data, 500); // Menggunakan kode status HTTP 500 untuk error
    //     }

    //     // Redirect pengguna ke halaman pembayaran Midtrans
    //     return redirect()->away('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snap_token)
    //         ->with(['transaction_id' => $transaction->id]);
    // }


    // MidtransAPIWebhookController.php
    public function generateMidtransToken(Request $request)
    {
        // Buat transaksi baru di Midtrans
        $response = Http::get('https://app.sandbox.midtrans.com/snap/v1/transactions', [
            'transaction_details' => [
                'order_id' => 'ORDER-12345678',
                'gross_amount' => 100000,
            ],
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            $token = $responseData['token'];
            $transactionId = $responseData['transaction_id'];

            // Simpan token dan ID transaksi ke dalam database atau sesuai kebutuhan

            return response()->json([
                'token' => $token,
                'transaction_id' => $transactionId,
            ]);
        } else {
            return response()->json([
                'message' => 'Error generating Midtrans token',
            ], $response->status());
        }
    }
}
