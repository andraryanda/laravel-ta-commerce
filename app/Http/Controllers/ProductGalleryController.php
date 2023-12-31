<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;
use App\Imports\ProductGalleryImport;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\ProductGalleryRequest;
use Illuminate\Contracts\Encryption\DecryptException;
use Maatwebsite\Excel\Facades\Excel;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($encryptedProduct)
    {
        $productId = Crypt::decrypt($encryptedProduct);
        $product = Product::find($productId);
        if (request()->ajax()) {
            $query = ProductGallery::where('products_id', $product->id);

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
            <div class="flex justify-start items-center space-x-3.5">
                <button type="button" title="Delete"
                    class="flex flex-col delete-button shadow-sm items-center justify-center w-20 h-12 border border-red-500 bg-red-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-red-500 focus:outline-none focus:shadow-outline"
                    data-id="' . Crypt::encrypt($item->id) . '">
                    <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/delete.png') . '" alt="delete" loading="lazy" width="20" />
                    <p class="mt-1 text-xs">Delete</p>
                </button>
            </div>
                ';
                })
                ->editColumn('url', function ($item) {
                    return '
            <img style="max-width: 150px;" src="' . $item->url . '"/>';
                })
                // <p>'.$item->url.'</p>
                ->editColumn('is_featured', function ($item) {
                    return $item->is_featured ? 'Yes' : 'No';
                })
                ->rawColumns(['action', 'url'])
                ->make();
        }

        return view('pages.dashboard.gallery.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($encryptedProduct)
    {
        $productId = Crypt::decrypt($encryptedProduct);
        $product = Product::find($productId);

        return view('pages.dashboard.gallery.create', compact('product'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ProductGalleryRequest $request, $productId)
    {
        try {
            // Dekripsi productId untuk mendapatkan id produk asli
            $productId = decrypt($productId);
            $product = Product::findOrFail($productId);

            $files = $request->file('files');
            if ($request->hasFile('files')) {
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = hash('sha256', time()) . '.' . $extension;
                    $path = $file->storeAs('public/gallery', $filename);

                    ProductGallery::create([
                        'products_id' => $product->id,
                        'url' => $path
                    ]);
                }
            }

            return redirect()->route('dashboard.product.gallery.index', encrypt($product->id))
                ->withSuccess('Gallery berhasil ditambahkan!');
        } catch (DecryptException $e) {
            // Handling jika terjadi kesalahan dekripsi
            return back()->withError(['error' => 'Invalid payload.']);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductGallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(ProductGallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductGallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductGallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductGallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(ProductGalleryRequest $request, ProductGallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy($encryptedId)
    {
        try {
            // Mendekripsi ID galeri
            $id = Crypt::decrypt($encryptedId);

            // Menemukan galeri berdasarkan ID
            $gallery = ProductGallery::find($id);

            if (!$gallery) {
                // Lakukan penanganan jika galeri tidak ditemukan
                abort(404);
            }

            $gallery->delete();

            return redirect()->route('dashboard.product.gallery.index', $gallery->products_id)
                ->with('success', 'Gallery successfully deleted.');
        } catch (DecryptException $e) {
            // Tangani exception jika terjadi error pada dekripsi
            return back()->withErrors(['error' => 'Invalid payload.']);
        }
    }

    // public function importProductGallery(Request $request, Product $productId)
    // {
    //     try {
    //         $file = request()->file('file');

    //         // Validasi tipe file
    //         $allowedTypes = ['xlsx', 'csv'];
    //         $fileExtension = $file->getClientOriginalExtension();
    //         if (!in_array($fileExtension, $allowedTypes)) {
    //             throw new \Exception('File type not allowed, File must be type .XLSX & .CSV');
    //         }

    //         $productId = request('products_id'); // mendapatkan id produk dari form
    //         if (!$productId) {
    //             throw new \Exception('Product ID not provided.');
    //         }

    //         Excel::import(new ProductGalleryImport($productId), $file); // memanggil ProductGalleryImport dengan menyediakan product ID
    //         return redirect()->back()->withSuccess('Import successful!');
    //     } catch (\Exception $e) {
    //         $errorMessage = $e->getMessage();
    //         return redirect()->back()->with(compact('errorMessage'))->withError($e->getMessage());
    //     }
    // }
    public function importProductGallery(Request $request, Product $productId)
    {
        try {
            $file = $request->file('file');

            // Validasi tipe file
            $allowedTypes = ['xlsx', 'csv'];
            $fileExtension = $file->getClientOriginalExtension();
            if (!in_array($fileExtension, $allowedTypes)) {
                throw new \Exception('File type not allowed, File must be type .XLSX & .CSV');
            }

            Excel::import(new ProductGalleryImport($productId), $file); // memanggil ProductGalleryImport dengan menyediakan product ID
            return redirect()->back()->withSuccess('Import successful!');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->with(compact('errorMessage'))->withError($e->getMessage());
        }
    }
}
