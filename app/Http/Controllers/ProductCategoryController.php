<?php

namespace App\Http\Controllers;

use view;
use Exception;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use App\Imports\ProductCategoryImport;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\ProductCategoryRequest;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = ProductCategory::query()->OrderByDesc('created_at');

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    $encryptedId = Crypt::encrypt($item->id);
                    return '
                    <div class="flex justify-start items-center space-x-3.5">
                <button type="button" title="Edit"
                    class="flex flex-col edit-button shadow-sm items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                    data-id="' . $encryptedId . '">
                    <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="delete" loading="lazy" width="20" />
                    <p class="mt-1 text-xs">Edit</p>
                </button>
                        <button type="button" title="Delete"
                            class="flex flex-col delete-button shadow-sm items-center justify-center w-20 h-12 border border-red-500 bg-red-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-red-500 focus:outline-none focus:shadow-outline"
                            data-id="' . $encryptedId . '">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/delete.png') . '" alt="delete" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Delete</p>
                        </button>
                    </div>
                        ';
                })
                ->editColumn('price', function ($item) {
                    return number_format($item->price);
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard.category.index');
    }


    public function importCategory()
    {
        try {
            $file = request()->file('file');

            // Validasi tipe file
            $allowedTypes = ['xlsx', 'csv'];
            $fileExtension = $file->getClientOriginalExtension();
            if (!in_array($fileExtension, $allowedTypes)) {
                throw new \Exception('File type not allowed, File must be type .XLSX & .CSV');
            }

            Excel::import(new ProductCategoryImport, $file);
            return redirect()->back()->withSuccess('Import successful!');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->with(compact('errorMessage'))->withError($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductCategoryRequest $request)
    {
        try {
            $data = $request->all();

            $productCategory = ProductCategory::create([
                'name' => $data['name'],
            ]);

            if (!$productCategory) {
                throw new \Exception('Gagal menambahkan kategori produk');
            }

            return redirect()->route('dashboard.category.index')->withSuccess('Berhasil menambahkan kategori produk');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(ProductCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */

    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $category = ProductCategory::findOrFail($id);

            return view('pages.dashboard.category.edit', [
                'item' => $category
            ]);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return redirect()->back()->withError('Terjadi kesalahan dalam mendekripsi ID kategori.');
        } catch (\Exception $e) {
            return abort(500);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductCategoryRequest $request, ProductCategory $category)
    {
        try {
            $data = $request->all();

            $category->update($data);

            return redirect()->route('dashboard.category.index')
                ->withSuccess('Category berhasil diupdate!');
        } catch (\Throwable $th) {
            return redirect()->back()->withError('Category gagal diupdate!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $category = ProductCategory::find($id);

            if (!$category) {
                // Lakukan penanganan jika kategori tidak ditemukan
                abort(404);
            }

            $category->delete();

            return redirect()->route('dashboard.category.index')->with('success', 'Kategori telah dihapus.');
        } catch (DecryptException $e) {
            // Lakukan penanganan jika terjadi kesalahan dekripsi
            abort(404);
        }
    }
}
