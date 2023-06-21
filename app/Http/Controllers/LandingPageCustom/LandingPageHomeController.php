<?php

namespace App\Http\Controllers\LandingPageCustom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use App\Models\LandingPage\LandingPageHome;

class LandingPageHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $landingPageHome = LandingPageHome::get();

        if (request()->ajax()) {
            $query = landingPageHome::OrderByDesc('created_at');

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
                ->editColumn('image_carousel', function ($item) {
                    $imagePath =  $item->image_carousel;
                    $imageUrl = Storage::url($imagePath);
                    return '<img style="max-width: 150px;" class="rounded-lg shadow" src="' . $imageUrl . '"/>';
                })
                ->rawColumns(['action', 'image_carousel'])
                ->make();
        }
        return view('pages.landing_page.home.index', compact('landingPageHome'));
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

            "header_title_carousel" => "required",
            "title_carousel" => "required",
            "image_carousel" => "required|image|mimes:png,jpg,jpeg",
        ]);

        $carousel = new LandingPageHome();
        $carousel->header_title_carousel = $request->header_title_carousel;
        $carousel->title_carousel = $request->title_carousel;
        if ($request->hasFile("image_carousel")) {
            $image = $request->file('image_carousel');
            $extension = $image->getClientOriginalExtension();
            $filename = hash('sha256', $image->getClientOriginalName()) . '.' . $extension;
            $path = $image->storeAs('public/landingpage/home', $filename);
            $carousel->image_carousel = $path;
        }
        $carousel->save();

        return back()->withSuccess('success', 'Gambar Carousel berhasil disimpan.');
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
        $landingPageHome = LandingPageHome::findOrFail($id);
        return view('pages.landing_page.home.edit', compact('landingPageHome'));
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
            "header_title_carousel" => "required",
            "title_carousel" => "required",
            "image_carousel" => "image|mimes:png,jpg,jpeg",
        ]);

        $carousel = LandingPageHome::findOrFail($id);
        $carousel->header_title_carousel = $request->header_title_carousel;
        $carousel->title_carousel = $request->title_carousel;

        if ($request->hasFile("image_carousel")) {
            // Delete existing image if present
            if ($carousel->image_carousel) {
                Storage::delete($carousel->image_carousel);
            }

            $image = $request->file('image_carousel');
            $extension = $image->getClientOriginalExtension();
            $filename = hash('sha256', $image->getClientOriginalName()) . '.' . $extension;
            $path = $image->storeAs('public/landingpage/home', $filename);
            $carousel->image_carousel = $path;
        }

        $carousel->save();

        return redirect()->route('dashboard.carousel.index')->withSuccess('Gambar Carousel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carousel = LandingPageHome::findOrFail($id);

        // Delete image if present
        if ($carousel->image_carousel) {
            Storage::delete($carousel->image_carousel);
        }

        $carousel->delete();

        return back()->withSuccess('Gambar Carousel berhasil dihapus.');
    }
}
