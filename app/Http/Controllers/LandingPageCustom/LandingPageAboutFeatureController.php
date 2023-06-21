<?php

namespace App\Http\Controllers\LandingPageCustom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LandingPage\LandingPageAboutFeature;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class LandingPageAboutFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $landingPageAboutFeature = LandingPageAboutFeature::get();

        if (request()->ajax()) {
            $query = LandingPageAboutFeature::OrderByDesc('created_at');

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
                ->editColumn('image_about_feature', function ($item) {
                    $imagePath =  $item->image_about_feature;
                    $imageUrl = Storage::url($imagePath);
                    return '<img style="max-width: 150px;" class="rounded-lg shadow" src="' . $imageUrl . '"/>';
                })
                ->rawColumns(['action', 'image_about_feature'])
                ->make();
        }
        return view('pages.landing_page.about.feature.index', compact('landingPageAboutFeature'));
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
        $this->validate($request, [

            "title_about_feature" => "required",
            "description_about_feature" => "required",
            "image_about_feature" => "required|image|mimes:png,jpg,jpeg",
        ]);

        $landingPageAboutFeature = new LandingPageAboutFeature();
        $landingPageAboutFeature->title_about_feature = $request->title_about_feature;
        $landingPageAboutFeature->description_about_feature = $request->description_about_feature;
        if ($request->hasFile("image_about_feature")) {
            $image = $request->file('image_about_feature');
            $extension = $image->getClientOriginalExtension();
            $filename = hash('sha256', $image->getClientOriginalName()) . '.' . $extension;
            $path = $image->storeAs('public/landingpage/about', $filename);
            $landingPageAboutFeature->image_about_feature = $path;
        }
        $landingPageAboutFeature->save();

        return redirect()->route('dashboard.about-feature.index')->withSuccess('Data About Team berhasil disimpan.');
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
        $landingPageAboutFeature = LandingPageAboutFeature::findOrFail($id);
        // Lakukan logika atau operasi lain yang diperlukan untuk tampilan edit

        return view('pages.landing_page.about.feature.edit', compact('landingPageAboutFeature'));
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
            "title_about_feature" => "required",
            "description_about_feature" => "required",
            "image_about_feature" => "image|mimes:png,jpg,jpeg",
        ]);

        $landingPageAboutFeature = LandingPageAboutFeature::findOrFail($id);
        $landingPageAboutFeature->title_about_feature = $request->title_about_feature;
        $landingPageAboutFeature->description_about_feature = $request->description_about_feature;

        if ($request->hasFile("image_about_feature")) {
            $image = $request->file('image_about_feature');
            $extension = $image->getClientOriginalExtension();
            $filename = hash('sha256', $image->getClientOriginalName()) . '.' . $extension;
            $path = $image->storeAs('public/landingpage/about', $filename);

            // Hapus file lama sebelum menyimpan file yang baru
            Storage::delete($landingPageAboutFeature->image_about_feature);

            $landingPageAboutFeature->image_about_feature = $path;
        }

        $landingPageAboutFeature->save();

        return redirect()->route('dashboard.about-feature.index')->withSuccess('Data About Team berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $landingPageAboutFeature = LandingPageAboutFeature::findOrFail($id);

        // Hapus file gambar dari penyimpanan
        Storage::delete($landingPageAboutFeature->image_about_feature);

        // Hapus data dari database
        $landingPageAboutFeature->delete();

        return redirect()->route('dashboard.about-feature.index')->withSuccess('Data About Team berhasil dihapus.');
    }
}
