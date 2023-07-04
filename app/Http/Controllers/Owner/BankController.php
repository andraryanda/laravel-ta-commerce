<?php

namespace App\Http\Controllers\Owner;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::get();
        return view('owner.bank.index', compact('banks'));
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
        $this->validate(
            $request,
            [
                'sandi_bank' => 'required|string',
                'nama_bank' => 'required|string'
            ],
            [
                'sandi_bank.required' => 'Sandi Bank harus diisi!',
                'nama_bank.required' => 'Nama Bank harus diisi!'
            ]
        );

        $banksId = $request->id;
        $banks = Bank::updateOrCreate([
            'id' => $banksId
        ], [
            'sandi_bank' => $request->sandi_bank,
            'nama_bank' => $request->nama_bank
        ]);

        return Response()->json($banks)->withSuccess('Data bank berhasil ditambahkan!');
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
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $banks  = Bank::where($where)->first();

        return Response()->json($banks);
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
    public function destroy(Request $request)
    {
        $banks = Bank::where('id', $request->id)->delete();

        return Response()->json($banks)->withSuccess('Data bank berhasil dihapus!');
    }
}
