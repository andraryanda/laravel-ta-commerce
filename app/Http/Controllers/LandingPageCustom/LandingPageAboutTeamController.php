<?php

namespace App\Http\Controllers\LandingPageCustom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LandingPage\LandingPageAboutTeam;

class LandingPageAboutTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $landingPageAboutTeam = LandingPageAboutTeam::get();

        if (request()->ajax()) {
            $query = LandingPageAboutTeam::OrderByDesc('created_at');

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
                ->editColumn('image_people_team', function ($item) {
                    $imagePath =  $item->image_people_team;
                    $imageUrl = Storage::url($imagePath);
                    return '<img style="max-width: 150px;" class="rounded-lg shadow" src="' . $imageUrl . '"/>';
                })
                ->rawColumns(['action', 'image_people_team'])
                ->make();
        }
        return view('pages.landing_page.about.team.index', compact('landingPageAboutTeam'));
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

            "name_people_team" => "required",
            "job_people_team" => "required",
            "description_people_team" => "required",
            "image_people_team" => "required|image|mimes:png,jpg,jpeg",
        ]);

        $landingPageAboutTeam = new LandingPageAboutTeam();
        $landingPageAboutTeam->name_people_team = $request->name_people_team;
        $landingPageAboutTeam->job_people_team = $request->job_people_team;
        $landingPageAboutTeam->description_people_team = $request->description_people_team;
        if ($request->hasFile("image_people_team")) {
            $image = $request->file('image_people_team');
            $extension = $image->getClientOriginalExtension();
            $filename = hash('sha256', $image->getClientOriginalName()) . '.' . $extension;
            $path = $image->storeAs('public/landingpage/about', $filename);
            $landingPageAboutTeam->image_people_team = $path;
        }
        $landingPageAboutTeam->save();

        return redirect()->route('dashboard.about-team.index')->withSuccess('Data About Team berhasil disimpan.');
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
        $landingPageAboutTeam = LandingPageAboutTeam::findOrFail($id);
        // Lakukan logika atau operasi lain yang diperlukan untuk tampilan edit

        return view('pages.landing_page.about.team.edit', compact('landingPageAboutTeam'));
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
            "name_people_team" => "required",
            "job_people_team" => "required",
            "description_people_team" => "required",
            "image_people_team" => "image|mimes:png,jpg,jpeg",
        ]);

        $landingPageAboutTeam = LandingPageAboutTeam::findOrFail($id);
        $landingPageAboutTeam->name_people_team = $request->name_people_team;
        $landingPageAboutTeam->job_people_team = $request->job_people_team;
        $landingPageAboutTeam->description_people_team = $request->description_people_team;

        if ($request->hasFile("image_people_team")) {
            $image = $request->file('image_people_team');
            $extension = $image->getClientOriginalExtension();
            $filename = hash('sha256', $image->getClientOriginalName()) . '.' . $extension;
            $path = $image->storeAs('public/landingpage/about', $filename);
            $landingPageAboutTeam->image_people_team = $path;
        }

        $landingPageAboutTeam->save();

        return redirect()->route('dashboard.about-team.index')->withSuccess('Data About Team berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $landingPageAboutTeam = LandingPageAboutTeam::findOrFail($id);

        // Hapus file gambar dari penyimpanan
        Storage::delete($landingPageAboutTeam->image_people_team);

        // Hapus data dari database
        $landingPageAboutTeam->delete();

        return back()->withSuccess('Data About Team berhasil dihapus.');
    }


}
