<?php

namespace App\Http\Controllers\LandingPage;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Models\ProductCategory;
use App\Models\TransactionItem;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use App\Models\NotificationTransaction;
use App\Notifications\TransactionNotification;

class HalamanUtamaController extends Controller
{
    public function index()
    {

        $users_customer_count = User::where('roles', '=', 'USER')->count();
        $new_transaction = Transaction::count();
        $total_product = Product::count();
        $total_amount_success = Transaction::where('status', '=', 'SUCCESS')->sum('total_price');

        $products = Product::get();
        foreach ($products as $product) {
            // Menambahkan data ProductGallery ke setiap produk
            $product->productGallery = ProductGallery::where('products_id', $product->id)->get();
        }

        return view('landing_page.pages.index', compact(
            'products',
            'total_product',
            'users_customer_count',
            'new_transaction',
            'total_amount_success',
        ));
    }


    public function checkout(Request $request)
    {
        $request->validate([
            'products_id' => 'required|exists:products,id', // Validasi product_id
            'total_price' => 'required',
            'shipping_price' => 'required',
            'status' => 'required|in:PENDING,SUCCESS,CANCELLED,FAILED,SHIPPING,SHIPPED',
        ]);

        // Mendapatkan nilai incre_id terakhir
        $lastTransaction = Transaction::orderBy('incre_id', 'desc')->first();

        // Mengisi nilai incre_id baru pada transaksi yang akan dibuat
        $increId = $lastTransaction ? $lastTransaction->incre_id + 1 : 1;

        DB::beginTransaction();
        $transaction = Transaction::create([
            'id' => Transaction::generateTransactionId(),
            'incre_id' => $increId, // Mengisi nilai incre_id
            'users_id' => Auth::user()->id,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'shipping_price' => $request->shipping_price,
            'status' => $request->status,
        ]);

        $productModel = Product::findOrFail($request->products_id); // Mencari produk berdasarkan product_id dari form input

        if ($productModel) {
            $products_id = $productModel->id;

            TransactionItem::create([
                'id' => Transaction::generateTransactionId(),
                'incre_id' => $increId, // Mengisi nilai incre_id
                'users_id' => Auth::user()->id,
                'products_id' => $products_id,
                'transactions_id' => $transaction->id,
                'quantity' => 1 // Menggunakan nilai tetap 1 untuk quantity
            ]);
        } else {
            // Jika produk tidak ditemukan, melakukan penanganan kesalahan
            return redirect()->back()->withError('Produk tidak ditemukan.'); // Contoh: redirect kembali ke halaman sebelumnya dengan pesan error
        }

        NotificationTransaction::create([
            'transactions_id' => $transaction->incre_id
        ]);

        DB::commit();

        // Get the transaction and user data
        $transaction = Transaction::find($transaction->id);
        $user = Auth::user();

        // Send the email
        Mail::to('andraryandra38@gmail.com')->send(new TransactionNotification($transaction, $user));

        return redirect()->route('dashboard.payment', ['id' => $transaction->id])->withSuccess('Transaksi berhasil ditambahkan!');
        // return redirect()->route('dashboard.payment', ['id' => $transactionId])->withSuccess('Transaksi berhasil ditambahkan!');
    }



    public function show($encryptedId)
    {
        $id = decrypt($encryptedId); // Mendekripsi ID produk
        $product = Product::with('galleries')->with('category')->findOrFail($id);

        return view('landing_page.pages.checkout.checkout-shipping', compact('product'));
    }
}
