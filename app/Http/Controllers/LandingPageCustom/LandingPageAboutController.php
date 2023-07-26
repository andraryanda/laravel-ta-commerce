<?php

namespace App\Http\Controllers\LandingPageCustom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LandingPage\LandingPageAbout;

class LandingPageAboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $landingPageAbout = LandingPageAbout::get();

        if (request()->ajax()) {
            $query = LandingPageAbout::OrderByDesc('created_at');

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
                ->editColumn('image_about', function ($item) {
                    $imagePath =  $item->image_about;
                    $imageUrl = Storage::url($imagePath);
                    return '<img style="max-width: 150px;" class="rounded-lg shadow" src="' . $imageUrl . '"/>';
                })
                ->rawColumns(['action', 'image_about'])
                ->make();
        }
        return view('pages.landing_page.about.index', compact('landingPageAbout'));
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
        $existingAbout = LandingPageAbout::first();

        if ($existingAbout) {
            return back()->withError('Data About sudah tersedia.');
        }

        $this->validate($request, [
            "title_about" => "required",
            "description_about" => "required",
            "image_about" => "required|image|mimes:png,jpg,jpeg",
        ]);

        $landingPageAbout = new LandingPageAbout();
        $landingPageAbout->title_about = $request->title_about;
        $landingPageAbout->description_about = $request->description_about;
        if ($request->hasFile("image_about")) {
            $image = $request->file('image_about');
            $extension = $image->getClientOriginalExtension();
            $filename = hash('sha256', $image->getClientOriginalName()) . '.' . $extension;
            $path = $image->storeAs('public/landingpage/about', $filename);
            $landingPageAbout->image_about = $path;
        }
        $landingPageAbout->save();

        return back()->withSuccess('Gambar About berhasil disimpan.');
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
        $landingPageAbout = LandingPageAbout::findOrFail($id);
        return view('pages.landing_page.about.edit', compact('landingPageAbout'));
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
            "title_about" => "required",
            "description_about" => "required",
            "image_about" => "image|mimes:png,jpg,jpeg",
        ]);

        $landingPageAbout = LandingPageAbout::findOrFail($id);
        $landingPageAbout->title_about = $request->title_about;
        $landingPageAbout->description_about = $request->description_about;

        if ($request->hasFile("image_about")) {
            $image = $request->file('image_about');
            $extension = $image->getClientOriginalExtension();
            $filename = hash('sha256', $image->getClientOriginalName()) . '.' . $extension;
            $path = $image->storeAs('public/landingpage/about', $filename);
            $landingPageAbout->image_about = $path;
        }

        $landingPageAbout->save();

        return redirect()->route('dashboard.about-utama.index')->withSuccess('Data About berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $landingPageAbout = LandingPageAbout::findOrFail($id);
        $landingPageAbout->delete();

        return back()->withSuccess('Data About berhasil dihapus.');
    }
}
