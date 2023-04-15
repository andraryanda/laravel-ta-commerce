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
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard.product.index');
        // return view('components.pages_component.dashboard.product.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::all();
        return view('pages.dashboard.product.create', compact('categories'));
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

        Product::create($data);

        return redirect()->route('dashboard.product.index');
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
        $id = Crypt::decrypt($encryptedId); // Mendekripsi ID produk
        $product = Product::find($id);

        if (!$product) {
            // Lakukan penanganan jika produk tidak ditemukan
            abort(404);
        }

        $categories = ProductCategory::all();

        return view('pages.dashboard.product.edit', [
            'item' => $product,
            'categories' => $categories,
            'encryptedId' => $encryptedId // Menyertakan ID yang telah dienkripsi ke dalam view
        ]);
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

        $product->update($data);

        if (!$product) {
            return redirect()->route('dashboard.product.index')->withError('Product gagal diupdate!');
        } else {
            return redirect()->route('dashboard.product.index')->withSuccess('Product berhasil diupdate!');
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
        $id = Crypt::decrypt($encryptedId); // Mendekripsi ID produk
        $product = Product::find($id);

        if (!$product) {
            // Lakukan penanganan jika produk tidak ditemukan
            abort(404);
        }

        $product->delete();

        if (!$product) {
            return redirect()->route('dashboard.product.index')->withError('Product gagal dihapus!');
        } else {
            return redirect()->route('dashboard.product.index')->withSuccess('Product berhasil dihapus!');
        }
    }
}
