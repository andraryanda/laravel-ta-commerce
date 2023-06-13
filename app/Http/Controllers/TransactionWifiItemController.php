<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionWifi;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionWifiItem;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TransactionWifiRequest;
use Illuminate\Contracts\Encryption\DecryptException;

class TransactionWifiItemController extends Controller
{

    public function show($encryptedId)
{
    try {
        $id = Crypt::decrypt($encryptedId); // Mendekripsi ID transaksi
        $transaction = TransactionWifi::with(['items', 'wifi_items'])
        ->findOrFail($id);

        $transactionWifiItem = TransactionWifiItem::with(['product','wifis'])->first(); // Mengambil TransactionWifiItem yang sesuai, atau sesuaikan dengan kebutuhan Anda

        $users = User::where('roles', '=', 'USER')->get();
        $products = Product::with('galleries')->with('category')->get();
        $transactions = Transaction::with(['user','wifi_items'])->get();
        $banks = Bank::get();

        $status_wifi = [
            ['label' => 'Aktif', 'value' => 'ACTIVE'],
            ['label' => 'Tidak Aktif', 'value' => 'INACTIVE'],
        ];

        $status_payment = [
            ['label' => 'Sudah Dibayar', 'value' => 'PAID'],
            ['label' => 'Belum Dibayar', 'value' => 'UNPAID'],
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


        return view('pages.dashboard.pembayaran_wifi_bulan.transactionWifiItem.create', compact(
            'transaction'
            ,'transactionWifiItem',
            'users',
            'products',
            'transactions',
            'banks',
            'status_wifi',
            'status_payment',
            'status_payment_method'

        ));
    } catch (DecryptException $e) {
        return redirect()->route('landingPage.index')->with('error', 'Terjadi kesalahan dalam menampilkan transaksi');
    }
}


    public function store(Request $request)
    {
        try {
            $lastTransactionWifiItem = TransactionWifiItem::orderBy('incre_id', 'desc')->first();
            $increId = $lastTransactionWifiItem ? $lastTransactionWifiItem->incre_id + 1 : 1;

            DB::beginTransaction();

            // Ambil transaksi wifi berdasarkan ID yang diterima
            $transactionWifi = TransactionWifi::findOrFail($request->transaction_wifi_id);

            // Tambahkan 1 bulan ke expired_wifi
            $nextMonth = Carbon::parse($transactionWifi->expired_wifi)->addMonth();
            $transactionWifi->expired_wifi = $nextMonth;
            $transactionWifi->save();

            $transactionWifiItem = TransactionWifiItem::create([
                'id' => TransactionWifi::generateTransactionId(),
                'incre_id' => $increId,
                'users_id' => $request->users_id,
                'products_id' => $request->products_id,
                'transaction_wifi_id' => $request->transaction_wifi_id,
                'payment_status' => $request->payment_status,
                'payment_transaction' => $request->payment_transaction,
                'payment_method' => $request->payment_method,
                'payment_bank' => $request->payment_bank,
                'description' => $request->description,
            ]);

            DB::commit();

            // Redirect atau kembalikan respons
            $encryptedTransactionWifiId = Crypt::encrypt($transactionWifiItem->transaction_wifi_id);
            return redirect()->route('dashboard.bulan.show', $encryptedTransactionWifiId)->withSuccess('Transaction Wifi Item created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withError('Terjadi kesalahan: ' . $e->getMessage());
        }
    }






    public function edit($encryptedItemId)
    {
        try {
            $itemId = Crypt::decrypt($encryptedItemId); // Mendekripsi ID item
            $transactionWifiItem = TransactionWifiItem::findOrFail($itemId);
            $users = User::where('roles', '=', 'USER')->get();
            $products = Product::with('galleries')->with('category')->get();
            $transactions = Transaction::with(['user', 'wifi_items'])->get();
            $banks = Bank::get();
            $transactionWifi = TransactionWifi::with('wifi_items')->get();


            $status_wifi = [
                ['label' => 'Aktif', 'value' => 'ACTIVE'],
                ['label' => 'Tidak Aktif', 'value' => 'INACTIVE'],
            ];

            $status_payment = [
                ['label' => 'Sudah Dibayar', 'value' => 'PAID'],
                ['label' => 'Belum Dibayar', 'value' => 'UNPAID'],
            ];

            $status_payment_method = [
                ['label' => 'BANK TRANSFER', 'value' => 'BANK TRANSFER'],
                ['label' => 'MANUAL', 'value' => 'MANUAL'],
            ];
            // Lakukan penanganan jika item tidak ditemukan

            return view('pages.dashboard.pembayaran_wifi_bulan.transactionWifiItem.edit', compact(
                'transactionWifiItem',
                'users',
                'products',
                'transactions',
                'banks',
                'transactionWifi',
                'status_wifi',
                'status_payment',
                'status_payment_method'

            ));
        } catch (DecryptException $e) {
            return redirect()->route('landingPage.index')->with('error', 'Terjadi kesalahan dalam mengakses halaman edit');
        }
    }

    public function update(Request $request, $encryptedItemId)
    {
        try {
            $itemId = Crypt::decrypt($encryptedItemId);
            $transactionWifiItem = TransactionWifiItem::findOrFail($itemId);

            // Update the transaction wifi item
            $transactionWifiItem->update([
                'users_id' => $request->input('users_id'),
                // 'products_id' => $request->input('products_id'),
                'payment_status' => $request->input('payment_status'),
                'payment_transaction' => $request->input('payment_transaction'),
                'payment_method' => $request->input('payment_method'),
                'payment_bank' => $request->input('payment_bank'),
                'description' => $request->input('description'),
            ]);

            // // Find the transaction wifi related to the item
            $transactionWifi = TransactionWifi::findOrFail($transactionWifiItem->transaction_wifi_id);
            $encryptedTransactionWifiId = Crypt::encrypt($transactionWifi->id);

            // // Update the transaction wifi
            // $transactionWifi->update([
            //     'users_id' => $request->input('users_id'),
            //     'products_id' => $request->input('products_id'),
            //     'total_price_wifi' => $request->input('total_price_wifi'),
            //     'status' => $request->input('status'),
            //     'expired_wifi' => $request->input('expired_wifi'),
            // ]);

            // Redirect or return a response
            return redirect()->route('dashboard.bulan.show', $encryptedTransactionWifiId)->withSuccess('Transaction Wifi updated successfully');
        } catch (DecryptException $e) {
            return redirect()->back()->withError('Terjadi kesalahan dalam mengakses halaman edit');
        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan: ' . $e->getMessage());
        }
    }





}
