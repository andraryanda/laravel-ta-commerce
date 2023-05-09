<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionWifi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class TransactionWifiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('pages.dashboard.pembayaran_wifi_bulan.index');
        // if (request()->ajax()) {
        //     $query = TransactionWifi::with(['user'])
        //         ->orderBy('transactions.created_at', 'desc')
        //         ->get();
        //     return DataTables::of($query)
        //         ->addColumn('action', function ($item) {
        //             $encryptedId = Crypt::encrypt($item->id);
        //             $status = $item->status;
        //             if ($status == 'SUCCESS' || $status == 'CANCELLED') {
        //                 return '
        //             <div class="flex justify-start items-center space-x-3.5">
        //                 <a href="' . route('dashboard.transaction.sendMessage', $item->id) . '" title="WhatsApp" target="_blank"
        //                     class="inline-flex flex-col items-center justify-center w-20 h-12 bg-green-400 text-white rounded-md border border-green-500 transition duration-500 ease select-none hover:bg-green-500 focus:outline-none focus:shadow-outline">
        //                     <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/whatsapp.png') . '" alt="whatsapp" loading="lazy" width="20" />
        //                     <p class="mt-1 text-xs">WhatsApp</p>
        //                 </a>
        //                 <a href="' . route('dashboard.report.exportPDF', $encryptedId) . '" title="Kwitansi"
        //                     class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
        //                     <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/printer.png') . '" alt="printer" loading="lazy" width="20" />
        //                     <p class="mt-1 text-xs">Kwitansi</p>
        //                 </a>
        //                 <a href="' . route('dashboard.transaction.show', $encryptedId) . '" title="Show"
        //                     class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline">
        //                     <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/show.png') . '" alt="show" loading="lazy" width="20" />
        //                     <p class="mt-1 text-xs">Lihat</p>
        //                 </a>
        //                 <a href="' . route('dashboard.transaction.edit', $encryptedId) . '" title="Edit"
        //                     class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
        //                     <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="show" loading="lazy" width="20" />
        //                     <p class="mt-1 text-xs">Edit</p>
        //                 </a>
        //             </div>
        //            ';
        //             }
        //         })
        //         ->rawColumns(['action'])
        //         ->make();
        // }
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
    public function show($id)
    {
        //
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
