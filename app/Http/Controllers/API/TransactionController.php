<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\NotificationTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\TransactionNotification;

class TransactionController extends Controller
{
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

        return ResponseFormatter::success(
            $transaction->paginate($limit),
            'Data list transaksi berhasil diambil'
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

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
            'transactions_id' => $transaction->incre_id
        ]);

        // Get the transaction and user data
        $transaction = Transaction::find($transaction->id);
        $user = Auth::user();

        // Send the email
        Mail::to('andraryandra38@gmail.com')->send(new TransactionNotification($transaction, $user));

        return ResponseFormatter::success($transaction->load('items.product'), 'Transaksi berhasil');
    }
}
