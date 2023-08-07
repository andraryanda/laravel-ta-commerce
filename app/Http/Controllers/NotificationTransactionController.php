<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\NotificationTransaction;

class NotificationTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getCount()
    {
        $count = NotificationTransaction::count();
        return $count;
    }

    public function getData()
    {
        $data = NotificationTransaction::with('items')->get();
        return $data;
    }



    // public function index()
    // {

    //     $getNotify = NotificationTransaction::with('items')
    //         ->with('transaction')
    //         ->get();

    //     $notifyTransactions = $this->getData();
    //     return view('component_dashboard.navbar', [
    //         'notifyTransactionCount' => $this->getCount(),
    //         'notifyTransactions' => $notifyTransactions,
    //         'getNotify' => $getNotify,
    //     ],);
    // }

    public function index()
    {
        $transactions = NotificationTransaction::with('transaction')->get();
        $notif = NotificationTransaction::get();
        return view('component_dashboard.navbar', compact('transactions', 'notif'));
    }


    public function store(Request $request)
    {
        //
        NotificationTransaction::create([
            // 'transactions_id' => $request->transactions_id,
            'transactions_id' => Str::uuid(),
        ]);

        return response()->json([
            'message' => 'Notification transaction created successfully'
        ]);
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
    public function destroy(Request $request, $id)
    {
        // Find the notification by ID
        $notification = NotificationTransaction::find($id);

        // If the notification is found, delete it
        if ($notification) {
            DB::beginTransaction();
            try {
                $notification->delete();

                DB::commit();

                return redirect()->back()->with('success', 'Notifikasi Transaksi Produk berhasil dihapus!');
            } catch (\Exception $e) {
                DB::rollback();

                return redirect()->back()->with('error', 'Notifikasi Transaksi Produk berhasil dihapus!');
            }
        }

        // If the notification is not found, redirect back with an error message
        return redirect()->back()->with('error', 'Notification transaction not found');
    }

    public function destroyAll()
    {
        DB::beginTransaction();
        try {
            NotificationTransaction::truncate();

            DB::commit();

            return redirect()->back()->with('success', 'Semua Notifikasi Transaksi Produk berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus notifikasi transaksi produk.');
        }
    }
}
