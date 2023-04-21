<?php

namespace App\Http\Controllers\Customer;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Contracts\Encryption\DecryptException;

class TransactionCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $new_transaction = Transaction::where('users_id', Auth::user()->id)->count();
        $total_amount_success = Transaction::where('status', 'SUCCESS')->where('users_id', Auth::user()->id)->sum('total_price');
        $total_amount_pending = Transaction::where('status', 'PENDING')->where('users_id', Auth::user()->id)->sum('total_price');
        $sendMessage = Transaction::where('users_id', Auth::id())->get();


        if (request()->ajax()) {
            $query = Transaction::where('users_id', Auth::id())->orderByDesc('created_at')->get();
            return DataTables::of($query)
                ->addColumn('user.name', function ($item) {
                    return '
                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            <!-- Avatar with inset shadow -->
                            <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                ' . (Jetstream::managesProfilePhotos() ?
                        (Auth::user()->profile_photo_url ? '
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="' . Auth::user()->profile_photo_url . '"
                                            alt="' . $item->user->name . '" loading="lazy" />' : '
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="' . asset('img/default-avatar.jpg') . '"
                                            alt="' . $item->user->name . '" loading="lazy" />'
                        ) : '
                                    <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.22 0-4 1.78-4 4s1.78 4 4 4 4-1.78 4-4-1.78-4-4-4zm0 6c-1.11 0-2-.89-2-2s.89-2 2-2 2 .89 2 2-.89 2-2 2z" />
                                        </svg>
                                    </span>
                                ') . '
                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                            </div>
                            <div>
                                <p class="font-semibold">' . $item->user->name . '</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">@' . $item->user->username . '</p>
                            </div>
                        </div>
                    </td>
                ';
                })

                ->addColumn('status', function ($item) {
                    if ($item->status == 'SUCCESS') {
                        return '
                        <td class="px-4 py-3 text-xs">
                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                ' . $item->status . '
                            </span>
                        </td>
                    ';
                    } elseif ($item->status == 'PENDING') {
                        return '
                        <td class="px-4 py-3 text-xs">
                            <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                ' . $item->status . '
                            </span>
                        </td>
                    ';
                    } elseif ($item->status == 'CANCELLED') {
                        return '
                        <td class="px-4 py-3 text-xs">
                            <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
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

                ->addColumn('action', function ($item) {
                    $encryptedId = Crypt::encrypt($item->id);
                    $status = $item->status;
                    if ($status == 'SUCCESS' || $status == 'CANCELLED') {
                        return '
                    <div class="flex justify-start items-center space-x-3.5">
                        <a href="' . route('dashboard.report.exportPDF', $encryptedId) . '" title="Kwitansi"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/printer.png') . '" alt="printer" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Kwitansi</p>
                        </a>
                        <a href="' . route('dashboard.transactionCustomer.show', $encryptedId) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                    </div>
                   ';
                    } else {
                        return '
                        <div class="flex justify-start items-center space-x-3.5">
                            <a href="' . route('dashboard.report.exportPDF', $encryptedId) . '" title="Kwitansi"
                                class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                                <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/printer.png') . '" alt="printer" loading="lazy" width="20" />
                                <p class="mt-1 text-xs">Kwitansi</p>
                            </a>
                            <a href="' . route('dashboard.payment', $item->id) . '" target="_blank" title="Bayar"
                                class="flex flex-col shadow-sm items-center justify-center w-20 h-12 border border-purple-500 bg-purple-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-purple-500 focus:outline-none focus:shadow-outline">
                                <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/credit-card.png') . '" alt="Bayar" loading="lazy" width="20" />
                                <p class="mt-1 text-xs">Bayar</p>
                            </a>
                            <a href="' . route('dashboard.transactionCustomer.show', $encryptedId) . '" title="Show"
                                class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                                <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                                <p class="mt-1 text-xs">Lihat</p>
                            </a>
                        </div>
                       ';
                    }
                })
                ->rawColumns(['user.name', 'status', 'action'])
                ->make();
        }

        return view('pages.customer.transaction.index', compact(
            'new_transaction',
            'total_amount_success',
            'total_amount_pending',
            'sendMessage',
        ));
    }

    public function sendMessageCustomerTransaction(Transaction $transaction)
    {
        $phone_number = '+62' . substr_replace($transaction->user->phone, '', 0, 1);

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
        $message .= "*Email       : "  . $transaction->user->email . '*' . "\n";
        $message .= "*Phone       : "  . $transaction->user->phone . '*' . "\n";
        $message .= "*Alamat       : "  . $transaction->address . '*' . "\n\n";

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
            $message .= "*Al's Store: 085314005779*";
        }

        $url = 'https://wa.me/' . $phone_number . '?text=' . urlencode($message);
        return redirect()->away($url);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
            $transaction = Transaction::findOrFail($id);
            if (!$transaction) {
                // Lakukan penanganan jika transaksi tidak ditemukan
                abort(404);
            }

            // Verifikasi users_id sesuai dengan id pengguna yang sedang masuk
            if ($transaction->users_id != auth()->user()->id) {
                return redirect()->route('dashboard.indexDashboardCustomer')->withError('Anda tidak memiliki akses ke transaksi ini');
            }

            if (request()->ajax()) {
                $query = TransactionItem::with(['product'])->where('transactions_id', $transaction->id);

                return DataTables::of($query)
                    ->editColumn('product.price', function ($item) {
                        return number_format($item->product->price);
                    })
                    ->make();
            }

            return view('pages.customer.transaction.show', compact('transaction'));
        } catch (DecryptException $e) {
            return redirect()->route('dashboard.indexDashboardCustomer')->withError('Terjadi kesalahan dalam menampilkan transaksi');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
