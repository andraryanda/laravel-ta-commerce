<?php

namespace App\Http\Controllers;

use Midtrans\Config;
use GuzzleHttp\Client;
// use Midtrans\Transaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TestingMidtransController extends Controller
{
    // public function getStatus($id, $order_id)
    // {
    //     $serverKey = env('MIDTRANS_SERVER_KEY'); // Menggunakan server key dari env

    //     $url = "https://api.sandbox.midtrans.com/v2/{$order_id}/status";

    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json',
    //         'Authorization' => 'Basic ' . base64_encode($serverKey . ':'),
    //     ])->get($url);

    //     $transactionStatus = json_decode($response->body(), true);

    //     return view('testing_midtrans', ['transactionStatus' => $transactionStatus]);
    // }

    public function getStatus($id, $order_id)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY'); // Menggunakan server key dari env

        $url = "https://api.sandbox.midtrans.com/v2/{$order_id}/status";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($serverKey . ':'),
        ])->get($url);

        $transactionStatus = json_decode($response->body(), true);

        $transaction = Transaction::find($id); // Menggunakan ID transaksi

        return view('testing_midtrans', [
            'transactionStatus' => $transactionStatus,
            'transaction' => $transaction,
        ]);
    }




    public function getAllTransactions()
    {
        $serverKey = env('MIDTRANS_SERVER_KEY'); // Menggunakan server key dari env

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($serverKey . ':'),
        ])->get('https://api.sandbox.midtrans.com/v2/transactions');

        $transactions = json_decode($response->body(), true);

        $jsonTransactions = json_encode($transactions, JSON_PRETTY_PRINT);

        return view('testing_all_transaction_midtrans', ['jsonTransactions' => $jsonTransactions]);
    }
}
