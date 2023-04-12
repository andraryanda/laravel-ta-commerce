<?php

namespace App\Http\Controllers;

use Fpdf;
use Dompdf\Dompdf;
use Midtrans\Snap;
use Midtrans\Config;
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
use Psy\Formatter\SignatureFormatter;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TransactionRequest;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Contracts\DataTable;
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
                    <div class="flex justify-start items-center space-x-3.5">
                        <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
                            class="inline-flex flex-col items-center justify-center w-20 h-12 bg-green-400 text-white rounded-md border border-green-500 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">WhatsApp</p>
                        </a>
                        <a href="' . route('dashboard.report.exportPDF', $item->id) . '" title="Kwitansi"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/printer.png') . '" alt="printer" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Kwitansi</p>
                        </a>
                        <a href="' . route('dashboard.transaction.show', $item->id) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                        <a href="' . route('dashboard.transaction.edit', $item->id) . '" title="Edit"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Edit</p>
                        </a>
                    </div>
                   ';
                })
                // ->editColumn('total_price', function ($item) {
                //     return number_format($item->total_price).'.00';
                // })
                ->rawColumns(['user.name', 'status', 'action'])
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
                    <div class="flex justify-start space-x-3">
                        <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-green-500 bg-green-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">WhatsApp</p>
                        </a>
                        <a href="' . route('dashboard.report.exportPDF', $item->id) . '" title="Kwitansi"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/printer.png') . '" alt="printer" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Kwitansi</p>
                        </a>
                        <a href="' . route('dashboard.payment', $item->id) . '" target="_blank" title="Bayar"
                        class="flex flex-col shadow-sm items-center justify-center w-20 h-12 border border-purple-500 bg-purple-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-purple-500 focus:outline-none focus:shadow-outline">
                        <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/credit-card.png') . '" alt="Bayar" loading="lazy" width="20" />
                        <p class="mt-1 text-xs">Bayar</p>
                    </a>
                        <a href="' . route('dashboard.transaction.show', $item->id) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                        <a href="' . route('dashboard.transaction.edit', $item->id) . '" title="Edit"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Edit</p>
                        </a>


                    </div>
                    ';
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
                    return '
                    <div class="flex justify-start space-x-3">
                        <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-green-500 bg-green-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">WhatsApp</p>
                        </a>
                        <a href="' . route('dashboard.report.exportPDF', $item->id) . '" title="Kwitansi"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/printer.png') . '" alt="printer" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Kwitansi</p>
                        </a>
                        <a href="' . route('dashboard.transaction.show', $item->id) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                        <a href="' . route('dashboard.transaction.edit', $item->id) . '" title="Edit"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Edit</p>
                        </a>
                    </div>
                    ';
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
                    <div class="flex justify-start space-x-3">
                        <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-green-500 bg-green-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">WhatsApp</p>
                        </a>
                        <a href="' . route('dashboard.report.exportPDF', $item->id) . '" title="Kwitansi"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/printer.png') . '" alt="printer" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Kwitansi</p>
                        </a>
                        <a href="' . route('dashboard.transaction.show', $item->id) . '" title="Show"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Lihat</p>
                        </a>
                        <a href="' . route('dashboard.transaction.edit', $item->id) . '" title="Edit"
                            class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Edit</p>
                        </a>
                    </div>
                    ';
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

    public function handlefinish(Request $request)
    {
        // Set your server key from config file or env
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = !env('MIDTRANS_IS_SANDBOX');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $transaction = Transaction::where('id', $request->order_id)->firstOrFail();

        if ($request->status_code == 200) {
            if ($request->transaction_status == 'settlement') {
                $transaction->status = 'SUCCESS';
                $transaction->payment = 'Bank Transfer';
            } elseif ($request->transaction_status == 'capture') {
                $transaction->status = 'SUCCESS';
                $transaction->payment = 'Bank Transfer';
            } elseif ($request->transaction_status == 'pending') {
                $transaction->status = 'PENDING';
            } elseif ($request->transaction_status == 'deny') {
                $transaction->status = 'DENY';
                $transaction->payment = 'Bank Transfer';
                // tambahkan kode ini untuk membatalkan transaksi di Midtrans
                \Midtrans\Transaction::cancel($request->order_id);
            } elseif ($request->transaction_status == 'expire') {
                $transaction->status = 'EXPIRED';
                $transaction->payment = 'Bank Transfer';
                // tambahkan kode ini untuk membatalkan transaksi di Midtrans
                \Midtrans\Transaction::cancel($request->order_id);
            } elseif ($request->transaction_status == 'cancel') {
                $transaction->status = 'CANCELLED';
                $transaction->payment = 'Bank Transfer';
                // tambahkan kode ini untuk membatalkan transaksi di Midtrans
                \Midtrans\Transaction::cancel($request->order_id);
            } else {
                $transaction->status = 'CANCELLED';
                $transaction->payment = 'Bank Transfer';

                // tambahkan kode ini untuk membatalkan transaksi di Midtrans
                \Midtrans\Transaction::cancel($request->order_id);
            }
        } else {
            $transaction->status = 'CANCELLED';
            $transaction->payment = 'Bank Transfer';
            \Midtrans\Transaction::cancel($request->order_id);
        }

        $transaction->save();

        // tambahkan kode ini untuk menampilkan peringatan jika pengguna menekan tombol "Back to Merchant"
        if ($request->status_code == 404 && $request->transaction_status == 'cancel') {
            return redirect()->route('dashboard.midtrans.show', $transaction->id);
        }

        if ($transaction->status == 'SUCCESS') {
            return redirect()->route('dashboard.midtrans.show', $transaction->id)->with('success', 'Transaksi Berhasil');
        } else {
            return redirect()->route('dashboard.midtrans.show', $transaction->id)->with('error', 'Transaksi Cancelled');
        }
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

    public function showTransaction(Transaction $transaction)
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

    // public function pay($transactionId)
    // {
    //     // Set konfigurasi Midtrans
    //     Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    //     Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
    //     Config::$isSanitized = true;
    //     Config::$is3ds = true;

    //     // Ambil data transaksi dari database
    //     $transaction = Transaction::where('id', $transactionId)->firstOrFail();

    //     // Buat array data pembayaran
    //     $transactionDetails = array(
    //         'order_id' => $transaction->incre_id,
    //         'gross_amount' => $transaction->total_price + $transaction->shipping_price
    //     );

    //     // Kirim permintaan pembayaran ke Midtrans
    //     $paymentUrl = Snap::createTransaction($transactionDetails)->redirect_url;

    //     // Update status pembayaran transaksi ke PENDING
    //     $transaction->status = 'PENDING';
    //     $transaction->save();

    //     // Redirect pengguna ke halaman pembayaran Midtrans
    //     return redirect($paymentUrl);
    // }

    // public function payment($id)
    // {
    //     // Ambil data transaksi dari database
    //     $transaction = Transaction::findOrFail($id);

    //     // Set konfigurasi Midtrans
    //     Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    //     Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
    //     Config::$isProduction = false;
    //     Config::$isSanitized = true;
    //     Config::$is3ds = true;

    //     // Buat array data pembayaran
    //     $transactionDetails = array(
    //         'order_id' => $transaction->id,
    //         'gross_amount' => $transaction->total_price + $transaction->shipping_price
    //     );

    //     // Kirim permintaan pembayaran ke Midtrans
    //     $paymentUrl = Snap::createTransaction($transactionDetails)->redirect_url;

    //     // Redirect pengguna ke halaman pembayaran Midtrans
    //     return redirect($paymentUrl);
    // }

    // public function payment(Request $request, $id)
    // {
    //     // Set Midtrans API configuration
    //     Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    //     Config::$clientKey = env('MIDTRANS_CLIENT_KEY'); // Tambahkan baris ini
    //     Config::$isProduction = env('MIDTRANS_ENVIRONMENT') === 'production' ? true : false;
    //     Config::$isSanitized = true;
    //     Config::$is3ds = false;


    //     // Get transaction data from database
    //     $transaction = Transaction::findOrFail($id);

    //     // Get transaction items data from database
    //     $transaction_items = TransactionItem::where('transactions_id', $transaction->id)->get();

    //     // Set item details for Midtrans
    //     $items = [];
    //     foreach ($transaction_items as $item) {
    //         $item_detail = [
    //             'id' => $item->id,
    //             'price' => $item->product->price,
    //             'quantity' => $item->quantity,
    //             'name' => $item->product->name
    //         ];
    //         array_push($items, $item_detail);
    //     }

    //     // Set customer details for Midtrans
    //     $customer_details = [
    //         'first_name' => $transaction->user->name,
    //         'email' => $transaction->user->email,
    //         'phone' => $transaction->user->phone,
    //         'billing_address' => [
    //             'address' => $transaction->address,
    //             'country_code' => 'IDN'
    //         ]
    //     ];

    //     // Set transaction details for Midtrans
    //     $orderId = uniqid();
    //     $transaction_details = [
    //         'order_id' => $transaction->id,
    //         'gross_amount' => $transaction->total_price + $transaction->shipping_price,
    //         'customer_details' => $customer_details,
    //         'item_details' => $items
    //     ];

    //     try {
    //         // Create Snap Token for Midtrans payment page
    //         $snap_token = Snap::getSnapToken($transaction_details);

    //         // Redirect user to Midtrans payment page
    //         return redirect()->away('https://app.midtrans.com/snap/v1/transactions/' . $snap_token);
    //     } catch (\Exception $e) {
    //         return $e->getMessage();
    //     }
    // }

    // jadi
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
    //             // 'address' => $transaction->user->name,
    //             'address' => [
    //                 'address' => $transaction->user->name,
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
    //     return redirect()->away('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snap_token);
    // }




    // public function midtransNotification(Request $request, $id)
    // {
    //     Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
    //     Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    //     Config::$clientKey = env('MIDTRANS_CLIENT_KEY');

    //     $notification = new Notification();

    //     $orderId = $notification->order_id;
    //     $transactionStatus = $notification->transaction_status;

    //     if ($transactionStatus == 'capture') {
    //         // TODO: Ubah status pembayaran pada tabel transaksi
    //         // Sesuaikan dengan nama field dan model transaksi pada Laravel Anda
    //         $transaction = \App\Models\Transaction::where('id', $orderId)->firstOrFail();
    //         $transaction->status = 'SUCCESS';
    //         $transaction->save();
    //     } elseif ($transactionStatus == 'settlement') {
    //         // TODO: Ubah status pembayaran pada tabel transaksi
    //         // Sesuaikan dengan nama field dan model transaksi pada Laravel Anda
    //         $transaction = \App\Models\Transaction::where('id', $orderId)->firstOrFail();
    //         $transaction->status = 'SUCCESS';
    //         $transaction->save();
    //     } elseif ($transactionStatus == 'deny') {
    //         // TODO: Ubah status pembayaran pada tabel transaksi
    //         // Sesuaikan dengan nama field dan model transaksi pada Laravel Anda
    //         $transaction = \App\Models\Transaction::where('id', $orderId)->firstOrFail();
    //         $transaction->status = 'DENY';
    //         $transaction->save();
    //     }

    //     return response('OK', 200);
    // }

    // public function midtransNotification(Request $request)
    // {
    //     $transaction_id = $request->input('order_id');
    //     $transaction_status = $request->input('transaction_status');
    //     $fraud_status = $request->input('fraud_status');
    //     $transaction = Transaction::find($transaction_id);

    //     if ($transaction_status == 'settlement') {
    //         $transaction->status = 'SUCCESS';
    //     } else if ($fraud_status == 'accept') {
    //         $transaction->status = 'SUCCESS';
    //     } else if ($transaction_status == 'cancel') {
    //         $transaction->status = 'CANCELLED';
    //     }
    //     $transaction->save();

    //     return response()->json(['message' => 'Success']);
    // }




    // public function handleWebhook(Request $request)
    // {
    //     $orderId = $request->order_id;
    //     $transactionStatus = $request->transaction_status;

    //     if ($transactionStatus == 'CAPTURE' || $transactionStatus == 'SETTLEMENT') {
    //         // update transaction status to "success" in your database
    //         $transaction = Transaction::where('id', $orderId)->firstOrFail();
    //         $transaction->status = 'SUCCESS';
    //         $transaction->save();
    //     } else {
    //         // update transaction status to "cancelled" in your database
    //         $transaction = Transaction::where('id', $orderId)->firstOrFail();
    //         $transaction->status = 'CANCELLED';
    //         $transaction->save();
    //     }
    //     return redirect()->back();
    // }




    // public function payment($id)
    // {
    //     $transaction = Transaction::findOrFail($id);

    //     // Set konfigurasi midtrans
    //     Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    //     Config::$isProduction = env('MIDTRANS_ENVIRONMENT') === 'production' ? true : false;
    //     Config::$isSanitized = true;
    //     Config::$is3ds = false;

    //     // Buat array untuk data pembayaran
    //     $transaction_details = [
    //         'order_id' => $transaction->id,
    //         'gross_amount' => $transaction->total_price + $transaction->shipping_price,
    //         'customer_details' => [
    //             'first_name' => $transaction->user->name,
    //             'email' => $transaction->user->email,
    //         ],
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
    //     ];

    //     // Panggil API midtrans untuk membuat transaksi baru
    //     try {
    //         $snap_token = Snap::createTransaction($transaction_data)->token;
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['msg' => $e->getMessage()]);
    //     }

    //     // Redirect ke halaman pembayaran
    //     return redirect()->away('https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snap_token);
    // }

    // public function handleWebhook(Request $request)
    // {
    //     // Set konfigurasi midtrans
    //     Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    //     Config::$isProduction = env('MIDTRANS_ENVIRONMENT') === 'production' ? true : false;
    //     Config::$isSanitized = true;
    //     Config::$is3ds = true;

    //     // Buat instance notification midtrans
    //     $notification = new Notification();

    //     // Verifikasi signature
    //     if (!$notification->isValidSignature()) {
    //         return response('Invalid signature', 403);
    //     }

    //     // Update status transaksi di database
    //     $orderId = $notification->order_id;
    //     $transactionStatus = $notification->transaction_status;

    //     if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
    //         // update transaction status to "success" in your database
    //         $transaction = Transaction::where('id', $orderId)->firstOrFail();
    //         $transaction->status = 'SUCCESS';
    //         $transaction->save();

    //         // send email to user
    //         // Mail::to($transaction->user->email)->send(new PaymentSuccess($transaction));
    //     } else {
    //         // update transaction status to "cancelled" in your database
    //         $transaction = Transaction::where('id', $orderId)->firstOrFail();
    //         $transaction->status = 'CANCELLED';
    //         $transaction->save();
    //     }

    //     // Redirect ke halaman terima kasih Anda
    //     return redirect('/thank-you');
    // }


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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TransactionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
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

        return view('pages.dashboard.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Transaction $transaction)
    {
        return view('pages.dashboard.transaction.edit', [
            'item' => $transaction
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
