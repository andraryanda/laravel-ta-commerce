<?php

namespace App\Http\Controllers;

use Fpdf;
use Dompdf\Dompdf;
use Midtrans\Snap;
use App\Models\User;
use Midtrans\Config;
use App\Models\Product;
use Midtrans\Signature;
use Barryvdh\DomPDF\PDF;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Psy\Formatter\SignatureFormatter;
use App\Models\NotificationTransaction;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TransactionRequest;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Contracts\DataTable;
use App\Notifications\TransactionNotification;
use Illuminate\Contracts\Encryption\DecryptException;
use Symfony\Component\HttpFoundation\StreamedResponse;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Transaction::with(['user'])->orderByDesc('created_at');
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
                    return '
                    <a class="inline-block border border-blue-500 bg-blue-400 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline"
                        href="' . route('dashboard.transaction.show', $item->id) . '">
                        <div class="flex items-center">
                            <span class="material-symbols-outlined inline-block mr-2">visibility</span>
                            <p class="inline-block">Edit</p>
                        </div>
                    </a>
                    <a class="inline-block border border-blue-500 bg-blue-400 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline"
                    href="' . route('dashboard.transaction.print', $item->id) . '">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined inline-block mr-2">print</span>
                        <p class="inline-block">Print</p>
                    </div>
                </a>
                    <a class="inline-block border border-yellow-500 bg-yellow-400 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                        href="' . route('dashboard.transaction.edit', $item->id) . '">
                        <div class="flex items-center">
                            <span class="material-symbols-outlined inline-block mr-2">edit</span>
                            <p class="inline-block">Edit</p>
                        </div>
                    </a>
                    ';
                })
                // ->editColumn('total_price', function ($item) {
                //     return number_format($item->total_price).'.00';
                // })
                ->rawColumns(['user.name', 'status', 'action'])
                ->make();
        }

        return view('pages.dashboard.transaction.index');
    }

    public function indexAllTransaction()
    {
        $new_transaction = Transaction::count();
        $total_amount_success = Transaction::where('status', '=', 'SUCCESS')->sum('total_price');
        $total_amount_pending = Transaction::where('status', '=', 'PENDING')->sum('total_price');
        $total_amount_cancelled = Transaction::where('status', '=', 'CANCELLED')->sum('total_price');

        if (request()->ajax()) {
            $query = Transaction::with(['user'])
                ->orderBy('transactions.created_at', 'desc')
                ->get();
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    $encryptedId = Crypt::encrypt($item->id);
                    $status = $item->status;
                    if ($status == 'SUCCESS' || $status == 'CANCELLED') {
                        return '
                    <div class="flex justify-start items-center space-x-3.5">
                        <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
                            class="inline-flex flex-col items-center justify-center w-20 h-12 bg-green-400 text-white rounded-md border border-green-500 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">WhatsApp</p>
                        </a>
                        <a href="' . route('dashboard.report.exportPDF', $encryptedId) . '" title="Kwitansi"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/printer.png') . '" alt="printer" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Kwitansi</p>
                        </a>
                        <a href="' . route('dashboard.transaction.show', $encryptedId) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                        <a href="' . route('dashboard.transaction.edit', $encryptedId) . '" title="Edit"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Edit</p>
                        </a>
                    </div>
                   ';
                    } else {
                        return '
                    <div class="flex justify-start items-center space-x-3.5">
                        <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
                            class="inline-flex flex-col items-center justify-center w-20 h-12 bg-green-400 text-white rounded-md border border-green-500 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">WhatsApp</p>
                        </a>
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
                        <a href="' . route('dashboard.transaction.show', $encryptedId) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                        <a href="' . route('dashboard.transaction.edit', $encryptedId) . '" title="Edit"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Edit</p>
                        </a>
                    </div>
                   ';
                    }
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard.transaction.index_all_transaction', compact(
            'new_transaction',
            'total_amount_success',
            'total_amount_pending',
            'total_amount_cancelled',
        ));
    }

    public function indexPending()
    {
        $new_transaction = Transaction::where('status', '=', 'PENDING')->count();

        $total_amount_pending = Transaction::where('status', '=', 'PENDING')->sum('total_price');

        if (request()->ajax()) {
            $query = Transaction::with(['user'])->where('status', '=', 'PENDING')->orderBy('created_at', 'desc');

            return DataTables::of($query)
                ->editColumn('user.name', function ($item) {
                    if ($item->user->profile_photo_url) {
                        return '
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <!-- Avatar with inset shadow -->
                                    <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                        <img class="object-cover w-full h-full rounded-full" src="' . $item->user->profile_photo_url . '" alt="' . $item->user->name . '" loading="lazy" />
                                    </div>
                                    <div>
                                        <p class="font-semibold">' . $item->user->name . '</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">@' . $item->user->username . '</p>
                                    </div>
                                </div>
                            </td>
                        ';
                    } else {
                        return '
                            <td class="px-4 py-3">
                                <div class="flex items-center text-sm">
                                    <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.22 0-4 1.78-4 4s1.78 4 4 4 4-1.78 4-4-1.78-4-4-4zm0 6c-1.11 0-2-.89-2-2s.89-2 2-2 2 .89 2 2-.89 2-2 2z" />
                                        </svg>
                                    </span>
                                    <div>
                                        <p class="font-semibold">' . $item->user->name . '</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">@' . $item->user->username . '</p>
                                    </div>
                                </div>
                            </td>
                        ';
                    }
                })

                ->editColumn('status', function ($item) {
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

                ->editColumn('action', function ($item) {
                    $encryptedId = Crypt::encrypt($item->id);
                    $status = $item->status;
                    $userRole = Auth::user()->roles; // Menyimpan peran pengguna saat ini

                    if ($status == 'SUCCESS' || $status == 'CANCELLED') {
                        // Tampilkan tombol-tombol yang sesuai untuk semua peran
                        return '
                        <div class="flex justify-start items-center space-x-3.5">
                            <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
                                class="inline-flex flex-col items-center justify-center w-20 h-12 bg-green-400 text-white rounded-md border border-green-500 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                                <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                                <p class="mt-1 text-xs">WhatsApp</p>
                            </a>
                            <a href="' . route('dashboard.report.exportPDF', $encryptedId) . '" title="Kwitansi"
                                class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                                <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/printer.png') . '" alt="printer" loading="lazy" width="20" />
                                <p class="mt-1 text-xs">Kwitansi</p>
                            </a>
                            <a href="' . route('dashboard.transaction.show', $encryptedId) . '" title="Show"
                                class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                                <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                                <p class="mt-1 text-xs">Lihat</p>
                            </a>
                            <a href="' . route('dashboard.transaction.edit', $encryptedId) . '" title="Edit"
                                class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                                <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
                                <p class="mt-1 text-xs">Edit</p>
                            </a>';
                    } else {
                        // Tampilkan tombol Bayar jika peran adalah OWNER
                        if ($userRole == 'OWNER') {
                            return '
                            <div class="flex justify-start items-center space-x-3.5">
                                <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
                                    class="inline-flex flex-col items-center justify-center w-20 h-12 bg-green-400 text-white rounded-md border border-green-500 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                                    <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                                    <p class="mt-1 text-xs">WhatsApp</p>
                                </a>
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
                                <a href="' . route('dashboard.transaction.show', $encryptedId) . '" title="Show"
                                    class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                                    <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                                    <p class="mt-1 text-xs">Lihat</p>
                                </a>
                                <a href="' . route('dashboard.transaction.edit', $encryptedId) . '" title="Edit"
                                    class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                                    <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
                                    <p class="mt-1 text-xs">Edit</p>
                                </a>
                                <button type="button" title="Delete"
                                    class="flex flex-col delete-button shadow-sm items-center justify-center w-20 h-12 border border-red-500 bg-red-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-red-500 focus:outline-none focus:shadow-outline"
                                    data-id="' . $encryptedId . '">
                                    <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/delete.png') . '" alt="delete" loading="lazy" width="20" />
                                    <p class="mt-1 text-xs">Delete</p>
                                </button>
                            </div>
                            ';
                        }

                        return '
                        <div class="flex justify-start items-center space-x-3.5">
                        <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
                            class="inline-flex flex-col items-center justify-center w-20 h-12 bg-green-400 text-white rounded-md border border-green-500 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">WhatsApp</p>
                        </a>
                        <a href="' . route('dashboard.report.exportPDF', $encryptedId) . '" title="Kwitansi"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/printer.png') . '" alt="printer" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Kwitansi</p>
                        </a>
                        <a href="' . route('dashboard.transaction.show', $encryptedId) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                        <a href="' . route('dashboard.transaction.edit', $encryptedId) . '" title="Edit"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Edit</p>
                        </a>
                        <button type="button" title="Delete"
                            class="flex flex-col delete-button shadow-sm items-center justify-center w-20 h-12 border border-red-500 bg-red-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-red-500 focus:outline-none focus:shadow-outline"
                            data-id="' . $encryptedId . '">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/delete.png') . '" alt="delete" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Delete</p>
                        </button>
                    </div>
                        ';
                    }
                })


                // ->editColumn('total_price', function ($item) {
                //     return number_format($item->total_price).'.00';
                // })
                ->rawColumns(['user.name', 'status', 'action'])
                ->make();
        }

        return view('pages.dashboard.transaction.index_pending', compact('total_amount_pending', 'new_transaction'));
    }
    public function indexSuccess()
    {
        $new_transaction = Transaction::where('status', '=', 'SUCCESS')->count();

        $total_amount_success = Transaction::where('status', '=', 'SUCCESS')->sum('total_price');


        if (request()->ajax()) {
            $query = Transaction::with(['user'])->where('status', '=', 'SUCCESS');
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
                        <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
                            class="inline-flex flex-col items-center justify-center w-20 h-12 bg-green-400 text-white rounded-md border border-green-500 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">WhatsApp</p>
                        </a>
                        <a href="' . route('dashboard.report.exportPDF', $encryptedId) . '" title="Kwitansi"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/printer.png') . '" alt="printer" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Kwitansi</p>
                        </a>
                        <a href="' . route('dashboard.transaction.show', $encryptedId) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                        <a href="' . route('dashboard.transaction.edit', $encryptedId) . '" title="Edit"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Edit</p>
                        </a>
                    </div>
                   ';
                    } else {
                        return '
                    <div class="flex justify-start items-center space-x-3.5">
                        <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
                            class="inline-flex flex-col items-center justify-center w-20 h-12 bg-green-400 text-white rounded-md border border-green-500 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">WhatsApp</p>
                        </a>
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
                        <a href="' . route('dashboard.transaction.show', $encryptedId) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                        <a href="' . route('dashboard.transaction.edit', $encryptedId) . '" title="Edit"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Edit</p>
                        </a>
                    </div>
                   ';
                    }
                })
                ->rawColumns(['user.name', 'status', 'action'])
                ->make();
        }

        return view('pages.dashboard.transaction.index_success', compact('total_amount_success', 'new_transaction'));
    }

    public function indexCancelled()
    {
        $new_transaction = Transaction::where('status', '=', 'CANCELLED')->count();

        $total_amount_cancelled = Transaction::where('status', '=', 'CANCELLED')->sum('total_price');

        if (request()->ajax()) {
            $query = Transaction::with(['user'])->where('status', '=', 'CANCELLED')->orderByDesc('created_at');
            return DataTables::of($query)
                ->editColumn('user.name', function ($item) {
                    if ($item->user->profile_photo_url) {
                        return '
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <!-- Avatar with inset shadow -->
                                <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                    <img class="object-cover w-full h-full rounded-full" src="' . $item->user->profile_photo_url . '" alt="' . $item->user->name . '" loading="lazy" />
                                </div>
                                <div>
                                    <p class="font-semibold">' . $item->user->name . '</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">@' . $item->user->username . '</p>
                                </div>
                            </div>
                        </td>
                    ';
                    } else {
                        return '
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.22 0-4 1.78-4 4s1.78 4 4 4 4-1.78 4-4-1.78-4-4-4zm0 6c-1.11 0-2-.89-2-2s.89-2 2-2 2 .89 2 2-.89 2-2 2z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-semibold">' . $item->user->name . '</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">@' . $item->user->username . '</p>
                                </div>
                            </div>
                        </td>
                    ';
                    }
                })

                ->editColumn('status', function ($item) {
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

                ->editColumn('action', function ($item) {
                    $encryptedId = Crypt::encrypt($item->id);
                    $status = $item->status;
                    if ($status == 'SUCCESS' || $status == 'CANCELLED') {
                        return '
                    <div class="flex justify-start items-center space-x-3.5">
                        <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
                            class="inline-flex flex-col items-center justify-center w-20 h-12 bg-green-400 text-white rounded-md border border-green-500 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">WhatsApp</p>
                        </a>
                        <a href="' . route('dashboard.report.exportPDF', $encryptedId) . '" title="Kwitansi"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/printer.png') . '" alt="printer" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Kwitansi</p>
                        </a>
                        <a href="' . route('dashboard.transaction.show', $encryptedId) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                        <a href="' . route('dashboard.transaction.edit', $encryptedId) . '" title="Edit"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Edit</p>
                        </a>
                    </div>
                   ';
                    } else {
                        return '
                    <div class="flex justify-start items-center space-x-3.5">
                        <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
                            class="inline-flex flex-col items-center justify-center w-20 h-12 bg-green-400 text-white rounded-md border border-green-500 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">WhatsApp</p>
                        </a>
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
                        <a href="' . route('dashboard.transaction.show', $encryptedId) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                        <a href="' . route('dashboard.transaction.edit', $encryptedId) . '" title="Edit"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Edit</p>
                        </a>
                    </div>
                   ';
                    }
                })
                // ->editColumn('total_price', function ($item) {
                //     return number_format($item->total_price).'.00';
                // })
                ->rawColumns(['user.name', 'status', 'action'])
                ->make();
        }

        return view('pages.dashboard.transaction.index_cancelled', compact('total_amount_cancelled', 'new_transaction'));
    }

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
    //     ];

    //     // Panggil API midtrans untuk membuat transaksi baru
    //     try {
    //         $snap_token = Snap::createTransaction($transaction_data)->token;
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['msg' => $e->getMessage()]);
    //     }
    //     // Redirect ke halaman pembayaran
    //     return redirect()->away('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snap_token)
    //         ->with(['transaction_id' => $transaction->id]);
    // }

    // public function handlefinish(Request $request)
    // {
    //     // Set your server key from config file or env
    //     Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    //     Config::$isProduction = !env('MIDTRANS_IS_SANDBOX');
    //     Config::$isSanitized = true;
    //     Config::$is3ds = true;

    //     $transaction = Transaction::where('id', $request->order_id)->firstOrFail();

    //     if ($request->status_code == 200) {
    //         if ($request->transaction_status == 'settlement') {
    //             $transaction->status = 'SUCCESS';
    //             $transaction->payment = 'Bank Transfer';
    //         } elseif ($request->transaction_status == 'capture') {
    //             $transaction->status = 'SUCCESS';
    //             $transaction->payment = 'Bank Transfer';
    //         } elseif ($request->transaction_status == 'pending') {
    //             $transaction->status = 'PENDING';
    //         } elseif ($request->transaction_status == 'deny') {
    //             $transaction->status = 'DENY';
    //             $transaction->payment = 'Bank Transfer';
    //             // tambahkan kode ini untuk membatalkan transaksi di Midtrans
    //             \Midtrans\Transaction::cancel($request->order_id);
    //         } elseif ($request->transaction_status == 'expire') {
    //             $transaction->status = 'EXPIRED';
    //             $transaction->payment = 'Bank Transfer';
    //             // tambahkan kode ini untuk membatalkan transaksi di Midtrans
    //             \Midtrans\Transaction::cancel($request->order_id);
    //         } elseif ($request->transaction_status == 'cancel') {
    //             $transaction->status = 'CANCELLED';
    //             $transaction->payment = 'Bank Transfer';
    //             // tambahkan kode ini untuk membatalkan transaksi di Midtrans
    //             \Midtrans\Transaction::cancel($request->order_id);
    //         } else {
    //             $transaction->status = 'CANCELLED';
    //             $transaction->payment = 'Bank Transfer';

    //             // tambahkan kode ini untuk membatalkan transaksi di Midtrans
    //             \Midtrans\Transaction::cancel($request->order_id);
    //         }
    //     } else {
    //         $transaction->status = 'CANCELLED';
    //         $transaction->payment = 'Bank Transfer';
    //         \Midtrans\Transaction::cancel($request->order_id);
    //     }

    //     $transaction->save();

    //     // tambahkan kode ini untuk menampilkan peringatan jika pengguna menekan tombol "Back to Merchant"
    //     if ($request->status_code == 404 && $request->transaction_status == 'cancel') {
    //         return redirect()->route('dashboard.midtrans.show', $transaction->id);
    //     }

    //     if ($transaction->status == 'SUCCESS') {
    //         return redirect()->route('dashboard.midtrans.show', $transaction->id)->with('success', 'Transaksi Berhasil');
    //     } else {
    //         return redirect()->route('dashboard.midtrans.show', $transaction->id)->with('error', 'Transaksi Cancelled');
    //     }
    // }


    //Payment Notification URL*
    // public function notification(Request $request)
    // {
    //     // Set your server key from config file or env
    //     Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    //     Config::$isProduction = !env('MIDTRANS_IS_SANDBOX');
    //     Config::$isSanitized = true;
    //     Config::$is3ds = true;

    //     $notif = new Notification();

    //     $transaction = Transaction::where('id', $notif->order_id)->firstOrFail();

    //     // Handle notification status
    //     switch ($notif->transaction_status) {
    //         case 'capture':
    //             if ($notif->fraud_status == 'challenge') {
    //                 // Handle if payment is challenged
    //                 $transaction->status = 'CHALLENGE';
    //                 $transaction->save();
    //             } else if ($notif->fraud_status == 'accept') {
    //                 // Handle if payment is accepted
    //                 $transaction->status = 'SUCCESS';
    //                 $transaction->save();
    //             }
    //             break;
    //         case 'settlement':
    //             // Handle if payment is settled
    //             $transaction->status = 'SUCCESS';
    //             $transaction->save();
    //             break;
    //         case 'deny':
    //             // Handle if payment is denied
    //             $transaction->status = 'DENY';
    //             $transaction->save();
    //             break;
    //         case 'expire':
    //             // Handle if payment is expired
    //             $transaction->status = 'EXPIRED';
    //             $transaction->save();
    //             break;
    //         case 'cancel':
    //             // Handle if payment is canceled
    //             $transaction->status = 'CANCELLED';
    //             $transaction->save();
    //             break;
    //         case 'pending':
    //             // Handle if payment is pending
    //             $transaction->status = 'PENDING';
    //             $transaction->save();
    //             break;
    //         default:
    //             // Handle if transaction status is unknown
    //             $transaction->status = 'UNKNOWN';
    //             $transaction->save();
    //             break;
    //     }

    //     return response()->json(['success' => true]);
    // }

    //Recurring Notification URL*
    // public function notificationHandler(Request $request)
    // {
    //     // Set your server key from config file or env
    //     Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    //     Config::$isProduction = !env('MIDTRANS_IS_SANDBOX');
    //     Config::$isSanitized = true;
    //     Config::$is3ds = true;

    //     // Get transaction data from the request
    //     $transaction = Transaction::where('id', $request->order_id)->firstOrFail();

    //     // Handle the notification
    //     $notification = new Notification();

    //     switch ($notification->transaction_status) {
    //         case 'capture':
    //             if ($notification->fraud_status == 'challenge') {
    //                 $transaction->status = 'PENDING';
    //             } else if ($notification->fraud_status == 'accept') {
    //                 $transaction->status = 'SUCCESS';
    //             }
    //             break;
    //         case 'settlement':
    //             $transaction->status = 'SUCCESS';
    //             break;
    //         case 'deny':
    //             $transaction->status = 'DENY';
    //             break;
    //         case 'expire':
    //             $transaction->status = 'EXPIRED';
    //             break;
    //         case 'cancel':
    //             $transaction->status = 'CANCELLED';
    //             break;
    //         default:
    //             $transaction->status = 'FAILED';
    //             break;
    //     }

    //     $transaction->save();

    //     return response()->json([
    //         'status' => 'OK',
    //     ]);
    // }

    public function showTransaction($encryptedId)
    {

        try {
            $id = Crypt::decrypt($encryptedId); // Mendekripsi ID transaksi
            $transaction = Transaction::find($id);
            if (!$transaction) {
                // Lakukan penanganan jika transaksi tidak ditemukan
                abort(404);
            }

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

        // if (request()->ajax()) {
        //     $query = TransactionItem::with(['product'])->where('transactions_id', $transaction->id);

        //     return DataTables::of($query)
        //         ->editColumn('product.price', function ($item) {
        //             return number_format($item->product->price);
        //         })
        //         ->make();
        // }

        // return view('pages.midtrans.index', compact('transaction'));
    }


    public function sendMessage(Transaction $transaction)
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

        $message = "Halo " . '*' . $transaction->user->name . '*' . ", terima kasih telah berbelanja di toko *Al's Store* kami. Berikut adalah detail pesanan Anda:\n\n";
        $message .= "-----------------------------------\n";
        $message .= "*Detail User:*\n";
        $message .= "*Nama       : "  . $transaction->user->name . '*' . "\n";
        $message .= "*Email        : "  . $transaction->user->email . '*' . "\n";
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
            $message .= "Silakan konfirmasi pembayaran Anda dengan mengirimkan bukti transfer ke nomor ini. Terima kasih. \n\n";
            $message .= "Silakan hubungi kami jika Anda memiliki pertanyaan atau masukan.\n";
            $message .= "*Al's Store: 085314005779*";
        } else if ($transaction->status == 'SUCCESS') {
            $message .= "Terima kasih telah menjadi pelanggan kami! \n";
            $message .= "Kami sangat menghargai kepercayaan Anda dan berharap dapat terus memberikan pelayanan terbaik. \n\n";
            $message .= "Silakan hubungi kami jika Anda memiliki pertanyaan atau masukan. \n\n";
            $message .= "*Al's Store: 085314005779*";
        } else if ($transaction->status == 'CANCELLED') {
            $message .= "*Maaf, pesanan Anda telah dibatalkan.* Silakan hubungi kami jika Anda memiliki pertanyaan atau masukan.\n\n";
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
        try {
            $users = User::where('roles', '=', 'USER')->get();
            $products = Product::with('galleries')->with('category')->get();

            $status_transaction = [
                ['label' => 'PENDING', 'value' => 'PENDING'],
                ['label' => 'SUCCESS', 'value' => 'SUCCESS'],
                ['label' => 'CANCELLED', 'value' => 'CANCELLED'],
            ];

            // Pengecekan data
            if ($users->isEmpty()) {
                throw new \Exception('Tidak ada data pengguna (users)');
            }

            if ($products->isEmpty()) {
                throw new \Exception('Tidak ada data produk (products)');
            }

            return view('pages.dashboard.transaction.create', compact(
                'products',
                'users',
                'status_transaction',
            ));
        } catch (\Exception $e) {
            // Tangani kesalahan di sini
            // Misalnya, tampilkan pesan kesalahan atau redirect ke halaman lain
            return redirect()->back()->withError('Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'users_id' => 'required',
                'address' => 'required',
                'shipping_price' => 'required|numeric',
                'status' => 'required',
                'products_id' => 'required',
                'quantity' => 'required|integer',
            ],
            [
                'users_id.required' => 'Pengguna harus diisi.',
                'address.required' => 'Alamat harus diisi.',
                'shipping_price.required' => 'Ongkos kirim harus diisi.',
                'shipping_price.numeric' => 'Ongkos kirim harus berupa angka.',
                'status.required' => 'Status harus diisi.',
                'products_id.required' => 'Produk harus diisi.',
                'quantity.required' => 'Jumlah harus diisi.',
                'quantity.integer' => 'Jumlah harus berupa angka.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $lastTransaction = Transaction::orderBy('incre_id', 'desc')->first();
        $increId = $lastTransaction ? $lastTransaction->incre_id + 1 : 1;

        DB::beginTransaction();

        try {
            $product = Product::find($request->products_id);

            $transaction = Transaction::create([
                'id' => Transaction::generateTransactionId(),
                'incre_id' => $increId,
                'users_id' => $request->users_id,
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
                'transactions_id' => $transaction->id
            ]);

            DB::commit();

            $transaction = Transaction::find($transaction->id);
            $user = Auth::user();

            Mail::to('andraryandra38@gmail.com')->send(new TransactionNotification($transaction, $user));
            Mail::to($user->email)->send(new TransactionNotification($transaction, $user));

            return redirect()->route('dashboard.transaction.indexPending')->withSuccess('Transaksi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['message' => 'Terjadi kesalahan saat membuat transaksi.']);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId); // Mendekripsi ID transaksi
            $transaction = Transaction::find($id);
            if (!$transaction) {
                // Lakukan penanganan jika transaksi tidak ditemukan
                abort(404);
            }

            if (request()->ajax()) {
                $query = TransactionItem::with(['product'])->where('transactions_id', $transaction->id);

                return DataTables::of($query)
                    ->editColumn('product.price', function ($item) {
                        return number_format($item->product->price);
                    })
                    ->make();
            }

            // Verifikasi role pengguna
            if (Auth::user()->roles != 'ADMIN' && Auth::user()->roles != 'OWNER' && $transaction->users_id != auth()->user()->id) {
                return redirect()->route('landingPage.index')->with('error', 'Anda tidak memiliki akses ke transaksi ini');
            }


            return view('pages.dashboard.transaction.show', compact('transaction'));
        } catch (DecryptException $e) {
            return redirect()->route('landingPage.index')->with('error', 'Terjadi kesalahan dalam menampilkan transaksi');
        }
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId); // Mendekripsi ID transaksi
            $transaction = Transaction::findOrFail($id);
            if (!$transaction) {
                // Lakukan penanganan jika transaksi tidak ditemukan
                abort(404);
            }

            return view('pages.dashboard.transaction.edit', [
                'item' => $transaction
            ]);
        } catch (DecryptException $e) {
            return redirect()->route('error.page')->with('error', 'Terjadi kesalahan dalam mengakses halaman edit transaksi');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TransactionRequest $request, $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId); // Mendekripsi ID transaksi
            $transaction = Transaction::find($id);
            if (!$transaction) {
                // Lakukan penanganan jika transaksi tidak ditemukan
                abort(404);
            }

            $data = $request->all();

            $transaction->update($data);

            if ($transaction->status == 'SUCCESS') {
                return redirect()->route('dashboard.transaction.indexSuccess')->withSuccess('Transaction Berhasil Diupdate!');
            } elseif ($transaction->status == 'PENDING') {
                return redirect()->route('dashboard.transaction.indexPending')->withSuccess('Transaction Berhasil Diupdate!');
            } elseif ($transaction->status == 'CANCELLED') {
                return redirect()->route('dashboard.transaction.indexCancelled')->withSuccess('Transaction Berhasil Diupdate!');
            } else {
                return redirect()->route('dashboard.index')->withSuccess('Transaction Berhasil Diupdate!');
            }
        } catch (DecryptException $e) {
            return redirect()->route('error.page')->with('error', 'Terjadi kesalahan dalam mengupdate transaksi');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $transaction = Transaction::find($id);

            if (!$transaction) {
                abort(404);
            }

            $transaction->delete();

            // Hapus juga data pada tabel transaction_items yang terkait dengan transaksi ini
            TransactionItem::where('transactions_id', $transaction->id)->delete();

            return redirect()->route('dashboard.transaction.index')->withSuccess('Transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.transaction.index')->withError('Transaksi gagal dihapus!');
        }
    }


    public function getUserAddress($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['address' => $user->alamat]);
    }
}
