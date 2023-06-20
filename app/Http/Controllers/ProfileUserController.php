<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::where('id','=',auth()->user()->id)->first();

        return view('pages.profileUser.index', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users=User::findOrFail($id);

        return view('pages.profileUser.edit', compact('users'));
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
        $this->validate($request, [

                'name' => 'required',
                'alamat' => 'nullable',
                'phone' => 'nullable',
            ],
            [

                'name.required' => 'Nama wajib diisi',
                'alamat.required' => 'Alamat wajib diisi',
                'phone.required' => 'No Telp wajib diisi',
            ]);

        $users = User::findOrFail($id);

       $users = User::where('id', $id)->update([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'phone' => $request->phone,
        ]);

        // dd($users);

        if ($users) {
            //redirect dengan pesan sukses
            return back()->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return back()->with(['error' => 'Data Gagal Diupdate!']);
        }
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
