<?php

namespace App\Http\Controllers\LandingPageCustom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LandingPage\LandingPageContact;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class LandingPageContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $landingPageContact = LandingPageContact::get();

        if (request()->ajax()) {
            $query = LandingPageContact::OrderByDesc('created_at');

            return DataTables::of($query)
                ->editColumn('action', function ($item) {
                    return '
                    <div class="flex justify-start items-center space-x-3.5">
                        <button type="button" title="Edit"
                            class="flex flex-col edit-button shadow-sm items-center justify-center w-20 h-12 border border-blue-500 bg-blue-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-blue-500 focus:outline-none focus:shadow-outline"
                            data-id="' . $item->id . '">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="edit" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Edit</p>
                        </button>
                        <button type="button" title="Delete"
                            class="flex flex-col delete-button shadow-sm items-center justify-center w-20 h-12 border border-red-500 bg-red-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-red-500 focus:outline-none focus:shadow-outline"
                            data-id="' . $item->id . '">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/delete.png') . '" alt="delete" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Delete</p>
                        </button>

                    </div>
                ';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.landing_page.contact.index', compact('landingPageContact'));
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
        $existingContact = LandingPageContact::first();

        if ($existingContact) {
            return redirect()->route('dashboard.contact.index')->withError('Data Contact sudah tersedia.');
        }

        $this->validate(
            $request,
            [
                "title_contact" => "required",
                "description_contact" => "required",
                "address_contact" => "required",
                "phone_contact" => "required",
                "email_contact" => "required",
            ],
            [
                'title_contact.required' => 'Title Contact harus diisi.',
                'description_contact.required' => 'Description Contact harus diisi.',
                'address_contact.required' => 'Address Contact harus diisi.',
                'phone_contact.required' => 'Phone Contact harus diisi.',
                'email_contact.required' => 'Email Contact harus diisi.',
            ]
        );

        $landingPageContact = new LandingPageContact();
        $landingPageContact->title_contact = $request->title_contact;
        $landingPageContact->description_contact = $request->description_contact;
        $landingPageContact->address_contact = $request->address_contact;
        $landingPageContact->phone_contact = $request->phone_contact;
        $landingPageContact->email_contact = $request->email_contact;

        $landingPageContact->save();

        return redirect()->route('dashboard.contact.index')->withSuccess('Data Contact berhasil disimpan.');
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
        $landingPageContact = LandingPageContact::findOrFail($id);
        // Lakukan logika atau operasi lain yang diperlukan untuk tampilan edit

        return view('pages.landing_page.contact.edit', compact('landingPageContact'));
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                "title_contact" => "required",
                "description_contact" => "required",
                "address_contact" => "required",
                "phone_contact" => "required",
                "email_contact" => "required",
            ],
            [
                'title_contact.required' => 'Title Contact harus diisi.',
                'description_contact.required' => 'Description Contact harus diisi.',
                'address_contact.required' => 'Address Contact harus diisi.',
                'phone_contact.required' => 'Phone Contact harus diisi.',
                'email_contact.required' => 'Email Contact harus diisi.',


            ]
        );

        $landingPageContact = LandingPageContact::findOrFail($id);
        $landingPageContact->title_contact = $request->title_contact;
        $landingPageContact->description_contact = $request->description_contact;
        $landingPageContact->address_contact = $request->address_contact;
        $landingPageContact->phone_contact = $request->phone_contact;
        $landingPageContact->email_contact = $request->email_contact;

        $landingPageContact->save();

        return redirect()->route('dashboard.contact.index')->withSuccess('Data Contact berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $landingPageContact = LandingPageContact::findOrFail($id);
        $landingPageContact->delete();

        return redirect()->route('dashboard.contact.index')->withSuccess('Data Contact berhasil dihapus.');
    }
}
