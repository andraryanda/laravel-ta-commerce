<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Product::with('category')->OrderByDesc('created_at');

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    $encryptedId = Crypt::encrypt($item->id);
                    return '
                        <div class="flex justify-start items-center space-x-3.5">
                            <button type="button" title="Gallery"
                                class="flex flex-col gallery-button shadow-sm items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline"
                                data-id="' . $encryptedId . '">
                                <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/picture.png') . '" alt="gambar" loading="lazy" width="20" />
                                <p class="mt-1 text-xs">Gallery</p>
                            </button>
                            <button type="button" title="Edit"
                                class="flex flex-col edit-button shadow-sm items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                                data-id="' . $encryptedId . '">
                                <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="edit" loading="lazy" width="20" />
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
                ->editColumn('status_product', function ($item) {
                    if ($item->status_product == 'ACTIVE') {
                        return '<span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">Active</span>';
                    } elseif ($item->status_product == '') {
                        return '<span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">Inactive</span>
                        <span class="px-2 py-1 font-semibold leading-tight mx-0.5">-</span>
                        <span class="px-2 py-1 font-semibold leading-tight text-yellow-600 bg-yellow-100 rounded-full">Empty</span>
                        ';
                    } else {
                        return '<span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">Inactive</span>';
                    }
                })


                ->rawColumns(['action', 'status_product'])
                ->make();
        }

        return view('pages.dashboard.product.index');
    }

    // public function index()
    // {
    //     if (request()->ajax()) {
    //         $query = Product::with('category')->OrderByDesc('created_at');

    //         return DataTables::of($query)
    //             ->addColumn('action', function ($item) {
    //                 $encryptedId = Crypt::encrypt($item->id);
    //                 return '
    //                 <div class="flex justify-start items-center space-x-3.5">

    //                     <button type="button" title="Gallery"
    //                         class="flex flex-col gallery-button shadow-sm items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline"
    //                         data-id="' . $encryptedId . '">
    //                         <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/picture.png') . '" alt="gambar" loading="lazy" width="20" />
    //                         <p class="mt-1 text-xs">Gallery</p>
    //                     </button>
    //                     <button type="button" title="Edit"
    //                         class="flex flex-col edit-button shadow-sm items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
    //                         data-id="' . $encryptedId . '">
    //                         <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="edit" loading="lazy" width="20" />
    //                         <p class="mt-1 text-xs">Edit</p>
    //                     </button>
    //                     <button type="button" title="Delete"
    //                         class="flex flex-col delete-button shadow-sm items-center justify-center w-20 h-12 border border-red-500 bg-red-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-red-500 focus:outline-none focus:shadow-outline"
    //                         data-id="' . $encryptedId . '">
    //                         <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/delete.png') . '" alt="delete" loading="lazy" width="20" />
    //                         <p class="mt-1 text-xs">Delete</p>
    //                     </button>
    //                 </div>
    //                 ';
    //             })
    //             ->editColumn('price', function ($item) {
    //                 return number_format($item->price);
    //             })
    //             ->rawColumns(['action'])
    //             ->chunk(100, function ($items) {
    //                 $data = [];
    //                 foreach ($items as $item) {
    //                     $data[] = $item;
    //                 }
    //                 return DataTables::collection($data)->make();
    //             });
    //     }

    //     return view('pages.dashboard.product.index');
    // }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $status_product = [
                ['label' => 'Tersedia', 'value' => 'ACTIVE'],
                ['label' => 'Tidak Tersedia', 'value' => 'INACTIVE'],
            ];

            $categories = ProductCategory::all();

            // Pengecekan data
            if ($categories->isEmpty()) {
                throw new \Exception('Tidak ada data kategori (categories)');
            }

            return view('pages.dashboard.product.create', [
                'status_product' => $status_product,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        try {
            Product::create($data);

            return redirect()->route('dashboard.product.index')->withSuccess('Berhasil menambahkan produk');
        } catch (\Exception $e) {
            return redirect()->back()->withError('Gagal menambahkan produk: ' . $e->getMessage());
        }

        // return redirect()->route('dashboard.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId); // Mendekripsi ID produk
            $product = Product::findOrFail($id);

            $categories = ProductCategory::all();

            $status_product = [
                ['label' => 'Tersedia', 'value' => 'ACTIVE'],
                ['label' => 'Tidak Tersedia', 'value' => 'INACTIVE'],
            ];


            return view('pages.dashboard.product.edit', [
                'item' => $product,
                'categories' => $categories,
                'encryptedId' => $encryptedId, // Menyertakan ID yang telah dienkripsi ke dalam view
                'status_product' => $status_product,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withError('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->all();

        try {
            $product->update($data);

            return redirect()->route('dashboard.product.index')->withSuccess('Product berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.product.index')->withError('Product gagal diupdate!')->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $product = Product::find($id);

            if (!$product) {
                abort(404);
            }

            $product->delete();

            return redirect()->route('dashboard.product.index')->withSuccess('Product berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.product.index')->withError('Product gagal dihapus!');
        }
    }
}
