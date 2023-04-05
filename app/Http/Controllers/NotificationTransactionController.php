<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
        return view('component_dashboard.navbar', compact('transactions'));
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
    public function destroy($id)
    {
        //
    }
}
