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
use App\Http\Requests\TransactionRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\LandingPage\LandingPageHome;
use App\Models\LandingPage\LandingPageContact;
use App\Notifications\TransactionNotification;

class HalamanUtamaController extends Controller
{
    public function index()
    {
        try {
            $users_customer_count = User::where('roles', '=', 'USER')->count();
            $new_transaction = Transaction::count();
            $total_product = Product::count();
            $total_amount_success = Transaction::where('status', '=', 'SUCCESS')->sum('total_price');

            $total_pending_count = 0;
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->roles == "ADMIN" || $user->roles == "OWNER") {
                    $total_pending_count = Transaction::where('status', '=', 'PENDING')->count();
                } else {
                    $total_pending_count = Transaction::where('status', '=', 'PENDING')->where('users_id', '=', $user->id)->count();
                }
            }

            $products = Product::paginate(4);
            foreach ($products as $product) {
                // Menambahkan data ProductGallery ke setiap produk
                $product->productGallery = ProductGallery::where('products_id', $product->id)->get();
            }

            $landingPageHome = LandingPageHome::get();
            $landingPageContact = LandingPageContact::get();


            return view('landing_page.pages.index', compact(
                'products',
                'total_product',
                'users_customer_count',
                'new_transaction',
                'total_amount_success',
                'total_pending_count',
                'landingPageHome',
                'landingPageContact'
            ));
        } catch (\Exception $e) {
            // Tangani kesalahan di sini
            // Misalnya, tampilkan pesan kesalahan atau redirect ke halaman lain
            return redirect()->back()->withError('Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    // public function checkout(Request $request)
    // {

    //     $request->validate([
    //         'products_id' => 'required|exists:products,id', // Validasi product_id
    //         'total_price' => 'required',
    //         'shipping_price' => 'required',
    //         'status' => 'required|in:PENDING,SUCCESS,CANCELLED,FAILED,SHIPPING,SHIPPED',
    //     ]);

    //     $lastTransaction = Transaction::orderBy('incre_id', 'desc')->first();

    //     $increId = $lastTransaction ? $lastTransaction->incre_id + 1 : 1;

    //     DB::beginTransaction();

    //     try {
    //         $transaction = Transaction::create([
    //             'id' => Transaction::generateTransactionId(),
    //             'incre_id' => $increId,
    //             'users_id' => Auth::user()->id,
    //             'address' => $request->address,
    //             'total_price' => $request->total_price,
    //             'shipping_price' => $request->shipping_price,
    //             'status' => $request->status,
    //         ]);

    //         TransactionItem::create([
    //             'id' => Transaction::generateTransactionId(),
    //             'incre_id' => $increId,
    //             'users_id' => Auth::user()->id,
    //             'products_id' => $request->products_id,
    //             'transactions_id' => $transaction->id,
    //             'quantity' => $request->quantity,
    //         ]);

    //         NotificationTransaction::create([
    //             // 'transactions_id' => $transaction->incre_id
    //             'transactions_id' => $transaction->id
    //         ]);

    //         DB::commit();

    //         $transaction = Transaction::find($transaction->id);
    //         $user = Auth::user();

    //         Mail::to('andraryandra38@gmail.com')->send(new TransactionNotification($transaction, $user));

    //         if ($request->has('bayar_sekarang')) {
    //             return redirect()->route('dashboard.payment', ['id' => $transaction->id])->withSuccess('Transaksi berhasil ditambahkan!');
    //         } else if ($request->has('bayar_manual')) {
    //             return redirect()->route('dashboard.transaction.sendMessageCustomerTransaction', ['transaction' => $transaction->id])->withSuccess('Transaksi berhasil ditambahkan!');
    //         }

    //         // return redirect()->route('dashboard.transaction.indexPending')->withSuccess('Transaksi berhasil dibuat.');
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()->withError(['message' => 'Terjadi kesalahan saat membuat transaksi.']);
    //     }
    // }

    public function checkout(Request $request)
    {
        $request->validate([
            'products_id' => 'required|exists:products,id', // Validasi product_id
            'total_price' => 'required',
            'shipping_price' => 'required',
            'status' => 'required|in:PENDING,SUCCESS,CANCELLED,FAILED,SHIPPING,SHIPPED',
        ]);

        $lastTransaction = Transaction::orderBy('incre_id', 'desc')->first();

        $increId = $lastTransaction ? $lastTransaction->incre_id + 1 : 1;

        DB::beginTransaction();

        try {
            $product = Product::find($request->products_id);

            $transaction = Transaction::create([
                'id' => Transaction::generateTransactionId(),
                'incre_id' => $increId,
                'users_id' => Auth::user()->id,
                'address' => $request->address,
                'total_price' => $product->price * $request->quantity, // Mengalikan harga dengan jumlah produk
                'shipping_price' => $request->shipping_price,
                'status' => $request->status,
            ]);

            TransactionItem::create([
                'id' => Transaction::generateTransactionId(),
                'incre_id' => $increId,
                'users_id' => $transaction->users_id,
                'products_id' => $request->products_id,
                'transactions_id' => $transaction->id,
                'quantity' => $request->quantity,
            ]);

            NotificationTransaction::create([
                // 'transactions_id' => $transaction->incre_id
                'transactions_id' => $transaction->id
            ]);

            DB::commit();

            $transaction = Transaction::find($transaction->id);
            $user = Auth::user();

            Mail::to('andraryandra38@gmail.com')->send(new TransactionNotification($transaction, $user));

            if ($request->has('bayar_sekarang')) {
                return redirect()->route('dashboard.payment', ['id' => $transaction->id])->withSuccess('Transaksi berhasil ditambahkan!');
            } else if ($request->has('bayar_manual')) {
                return redirect()->route('dashboard.transaction.sendMessageCustomerTransaction', ['transaction' => $transaction->id])->withSuccess('Transaksi berhasil ditambahkan!');
            }

            // return redirect()->route('dashboard.transaction.indexPending')->withSuccess('Transaksi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withError(['message' => 'Terjadi kesalahan saat membuat transaksi.']);
        }
    }


    public function sendMessageCustomerTransaction(Transaction $transaction)
    {
        // Nomor Handphone Admin
        $phone_number = '62' . '85314005779';

        $transaction_id = $transaction->id;

        $items = DB::table('transaction_items')
            ->join('products', 'transaction_items.products_id', '=', 'products.id')
            ->select('products.name', 'products.price', 'transaction_items.quantity')
            ->where('transactions_id', $transaction_id)
            ->get();

        $total = 0;
        foreach ($items as $item) {
            $total += $item->price * $item->quantity;
        }

        $message = "Halo " . '*' . 'Admin' . '*' . ", saya ingin melakukan pembayaran Manual. Berikut adalah detail pesanan:\n\n";
        $message .= "-----------------------------------\n";
        $message .= "*Detail User:*\n";
        $message .= "*Nama       : "  . $transaction->user->name . '*' . "\n";
        $message .= "*Email*        : " . ' ' . $transaction->user->email . ' ' . '' . "\n";
        $message .= "*Phone      : "  . $transaction->user->phone . '*' . "\n";
        $message .= "*Alamat     : "  . $transaction->address . '*' . "\n\n";

        $message .= "*Pesanan Transaksi:*\n";
        foreach ($items as $item) {
            $message .= "*Nama Produk       : "  . $item->name . '*' . "\n";
            $message .= "*Qty                        : "  . $item->quantity . '*' . "\n";
            $message .= "*Harga Produk       : Rp "  . number_format($item->price, 0, '.', ',') . '*' . "\n";
            $message .= "*Subtotal                : Rp "  . number_format($item->price * $item->quantity, 0, '.', ',') . '*' . "\n\n";
        }
        $message .= "*Total pembayaran : Rp "  . number_format($total, 0, '.', ',') . '*' . "\n";
        $message .= "*Status pesanan      : "  . $transaction->status . '*' . "\n\n";
        $message .= "-----------------------------------\n\n";

        // $message .= "Silakan konfirmasi pembayaran Anda dengan mengirimkan bukti transfer ke nomor ini. Terima kasih. \n\n";
        if ($transaction->status == 'PENDING') {
            $message .= "Harap bantuan dan informasinya. Terima kasih. \n\n";
        } else {
            $message .= "Silakan hubungi kami jika Anda memiliki pertanyaan atau masukan.\n";
            $message .= "*AL-N3T Support Gesitnet: 085314005779*";
        }

        $url = 'https://wa.me/' . $phone_number . '?text=' . urlencode($message);
        return redirect()->away($url);
    }


    public function show($encryptedId)
    {
        $id = decrypt($encryptedId); // Mendekripsi ID produk
        $product = Product::with('galleries')->with('category')->findOrFail($id);
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->roles == "ADMIN" || $user->roles == "OWNER") {
                $total_pending_count = Transaction::where('status', '=', 'PENDING')->count();
            } else {
                $total_pending_count = Transaction::where('status', '=', 'PENDING')->where('users_id', '=', $user->id)->count();
            }
        } else {
            $total_pending_count = 0;
        }

        $products = Product::get();
        $landingPageContact = LandingPageContact::get();



        return view('landing_page.pages.checkout.checkout-shipping', compact(
            'product',
            'products',
            'total_pending_count',
            'landingPageContact',
        ));
    }
}
