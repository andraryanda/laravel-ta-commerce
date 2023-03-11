<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\TransactionItem;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TransactionRequest;
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
                                '.(Jetstream::managesProfilePhotos() ?
                                    (Auth::user()->profile_photo_url ? '
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="'.Auth::user()->profile_photo_url.'"
                                            alt="'.$item->user->name.'" loading="lazy" />' : '
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="'.asset('img/default-avatar.jpg').'"
                                            alt="'.$item->user->name.'" loading="lazy" />'
                                    ) : '
                                    <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.22 0-4 1.78-4 4s1.78 4 4 4 4-1.78 4-4-1.78-4-4-4zm0 6c-1.11 0-2-.89-2-2s.89-2 2-2 2 .89 2 2-.89 2-2 2z" />
                                        </svg>
                                    </span>
                                ').'
                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                            </div>
                            <div>
                                <p class="font-semibold">'.$item->user->name.'</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">@'.$item->user->username.'</p>
                            </div>
                        </div>
                    </td>
                ';
            })

            ->addColumn('status', function ($item){
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
                        <i class="fa fa-eye"></i> Lihat
                    </a>
                    <a class="inline-block border border-yellow-500 bg-yellow-400 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                        href="' . route('dashboard.transaction.edit', $item->id) . '">
                        <i class="fa fa-pencil"></i> Edit
                    </a>';
            })
            // ->editColumn('total_price', function ($item) {
            //     return number_format($item->total_price).'.00';
            // })
            ->rawColumns(['user.name','status','action'])
            ->make();
        }

        return view('pages.dashboard.transaction.index');
    }

    public function indexAllTransaction()
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
                                '.(Jetstream::managesProfilePhotos() ?
                                    (Auth::user()->profile_photo_url ? '
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="'.Auth::user()->profile_photo_url.'"
                                            alt="'.$item->user->name.'" loading="lazy" />' : '
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="'.asset('img/default-avatar.jpg').'"
                                            alt="'.$item->user->name.'" loading="lazy" />'
                                    ) : '
                                    <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.22 0-4 1.78-4 4s1.78 4 4 4 4-1.78 4-4-1.78-4-4-4zm0 6c-1.11 0-2-.89-2-2s.89-2 2-2 2 .89 2 2-.89 2-2 2z" />
                                        </svg>
                                    </span>
                                ').'
                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                            </div>
                            <div>
                                <p class="font-semibold">'.$item->user->name.'</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">@'.$item->user->username.'</p>
                            </div>
                        </div>
                    </td>
                ';
            })

            ->addColumn('status', function ($item){
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
                        <i class="fa fa-eye"></i> Lihat
                    </a>
                    <a class="inline-block border border-yellow-500 bg-yellow-400 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                        href="' . route('dashboard.transaction.edit', $item->id) . '">
                        <i class="fa fa-pencil"></i> Edit
                    </a>';
            })
            // ->editColumn('total_price', function ($item) {
            //     return number_format($item->total_price).'.00';
            // })
            ->rawColumns(['user.name','status','action'])
            ->make();
        }

        return view('pages.dashboard.transaction.index_all_transaction');
    }

    public function indexPending()
    {
        if (request()->ajax()) {
            $query = Transaction::with(['user'])->where('status','=','PENDING')->orderByDesc('created_at');
            return DataTables::of($query)
            ->addColumn('user.name', function ($item) {
                return '
                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            <!-- Avatar with inset shadow -->
                            <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                '.(Jetstream::managesProfilePhotos() ?
                                    (Auth::user()->profile_photo_url ? '
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="'.Auth::user()->profile_photo_url.'"
                                            alt="'.$item->user->name.'" loading="lazy" />' : '
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="'.asset('img/default-avatar.jpg').'"
                                            alt="'.$item->user->name.'" loading="lazy" />'
                                    ) : '
                                    <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.22 0-4 1.78-4 4s1.78 4 4 4 4-1.78 4-4-1.78-4-4-4zm0 6c-1.11 0-2-.89-2-2s.89-2 2-2 2 .89 2 2-.89 2-2 2z" />
                                        </svg>
                                    </span>
                                ').'
                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                            </div>
                            <div>
                                <p class="font-semibold">'.$item->user->name.'</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">@'.$item->user->username.'</p>
                            </div>
                        </div>
                    </td>
                ';
            })

            ->addColumn('status', function ($item){
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
                        <i class="fa fa-eye"></i> Lihat
                    </a>
                    <a class="inline-block border border-yellow-500 bg-yellow-400 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                        href="' . route('dashboard.transaction.edit', $item->id) . '">
                        <i class="fa fa-pencil"></i> Edit
                    </a>';
            })
            // ->editColumn('total_price', function ($item) {
            //     return number_format($item->total_price).'.00';
            // })
            ->rawColumns(['user.name','status','action'])
            ->make();
        }

        return view('pages.dashboard.transaction.index_pending');
    }

    public function indexSuccess()
    {
        if (request()->ajax()) {
            $query = Transaction::with(['user'])->where('status','=','SUCCESS')->orderByDesc('created_at');
            return DataTables::of($query)
            ->addColumn('user.name', function ($item) {
                return '
                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            <!-- Avatar with inset shadow -->
                            <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                '.(Jetstream::managesProfilePhotos() ?
                                    (Auth::user()->profile_photo_url ? '
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="'.Auth::user()->profile_photo_url.'"
                                            alt="'.$item->user->name.'" loading="lazy" />' : '
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="'.asset('img/default-avatar.jpg').'"
                                            alt="'.$item->user->name.'" loading="lazy" />'
                                    ) : '
                                    <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.22 0-4 1.78-4 4s1.78 4 4 4 4-1.78 4-4-1.78-4-4-4zm0 6c-1.11 0-2-.89-2-2s.89-2 2-2 2 .89 2 2-.89 2-2 2z" />
                                        </svg>
                                    </span>
                                ').'
                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                            </div>
                            <div>
                                <p class="font-semibold">'.$item->user->name.'</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">@'.$item->user->username.'</p>
                            </div>
                        </div>
                    </td>
                ';
            })

            ->addColumn('status', function ($item){
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
                        <i class="fa fa-eye"></i> Lihat
                    </a>
                    <a class="inline-block border border-yellow-500 bg-yellow-400 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                        href="' . route('dashboard.transaction.edit', $item->id) . '">
                        <i class="fa fa-pencil"></i> Edit
                    </a>';
            })
            // ->editColumn('total_price', function ($item) {
            //     return number_format($item->total_price).'.00';
            // })
            ->rawColumns(['user.name','status','action'])
            ->make();
        }

        return view('pages.dashboard.transaction.index_success');
    }

    public function indexCancelled()
    {
        if (request()->ajax()) {
            $query = Transaction::with(['user'])->where('status','=','CANCELLED')->orderByDesc('created_at');
            return DataTables::of($query)
            ->addColumn('user.name', function ($item) {
                return '
                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            <!-- Avatar with inset shadow -->
                            <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                '.(Jetstream::managesProfilePhotos() ?
                                    (Auth::user()->profile_photo_url ? '
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="'.Auth::user()->profile_photo_url.'"
                                            alt="'.$item->user->name.'" loading="lazy" />' : '
                                        <img class="object-cover w-full h-full rounded-full"
                                            src="'.asset('img/default-avatar.jpg').'"
                                            alt="'.$item->user->name.'" loading="lazy" />'
                                    ) : '
                                    <span class="inline-block h-8 w-8 rounded-full overflow-hidden bg-gray-100">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M12 14.75c2.67 0 8 1.34 8 4v1.25H4v-1.25c0-2.66 5.33-4 8-4zm0-9.5c-2.22 0-4 1.78-4 4s1.78 4 4 4 4-1.78 4-4-1.78-4-4-4zm0 6c-1.11 0-2-.89-2-2s.89-2 2-2 2 .89 2 2-.89 2-2 2z" />
                                        </svg>
                                    </span>
                                ').'
                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                            </div>
                            <div>
                                <p class="font-semibold">'.$item->user->name.'</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">@'.$item->user->username.'</p>
                            </div>
                        </div>
                    </td>
                ';
            })

            ->addColumn('status', function ($item){
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
                        <i class="fa fa-eye"></i> Lihat
                    </a>
                    <a class="inline-block border border-yellow-500 bg-yellow-400 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                        href="' . route('dashboard.transaction.edit', $item->id) . '">
                        <i class="fa fa-pencil"></i> Edit
                    </a>';
            })
            // ->editColumn('total_price', function ($item) {
            //     return number_format($item->total_price).'.00';
            // })
            ->rawColumns(['user.name','status','action'])
            ->make();
        }

        return view('pages.dashboard.transaction.index_cancelled');
    }

    public function exportAllTransactions()
{
    $transactions = DB::table('transactions')
        ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transactions_id')
        ->join('users', 'transactions.users_id', '=', 'users.id')
        ->join('products', 'transaction_items.products_id', '=', 'products.id')
        ->select('transactions.id','transaction_items.products_id', 'transactions.users_id', 'users.name', 'transactions.address', 'products.name as product_name', 'transaction_items.quantity','transactions.total_price', 'transactions.shipping_price', 'transactions.status', 'transactions.payment', 'transactions.deleted_at', 'transactions.created_at', 'transactions.updated_at' )
        ->get();

    $headers = [
        'Content-Type' => 'text/csv',
        // 'Content-Disposition' => 'attachment; filename=all_transactions.csv',
        'Content-Disposition' => 'attachment; filename=all_transactions_' . date('d-m-Y') . '.csv',

    ];

    $callback = function () use ($transactions) {
        $file = fopen('php://output', 'w');

        fputcsv($file, ['Transaction ID','Product ID', 'User ID', 'User Name', 'Address', 'Product Name', 'Quantity','Total Price', 'Shipping Price', 'Status', 'Payment Method', 'Deleted At', 'Created At', 'Updated At' ]);

        foreach ($transactions as $transaction) {
            fputcsv($file, [$transaction->id,$transaction->products_id, $transaction->users_id,  $transaction->name,$transaction->address,$transaction->product_name,$transaction->quantity, $transaction->total_price, $transaction->shipping_price, $transaction->status, $transaction->payment, $transaction->deleted_at, $transaction->created_at, $transaction->updated_at ]);
        }

        fclose($file);
    };

    return new StreamedResponse($callback, 200, $headers);
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
        return view('pages.dashboard.transaction.edit',[
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

        return redirect()->route('dashboard.transaction.index');
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
