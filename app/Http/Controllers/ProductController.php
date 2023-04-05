<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
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
            $query = Product::with('category');

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                        <div class="flex justify-start items-center space-x-3.5">
                            <a href="' . route('dashboard.product.gallery.index', $item->id) . '" title="Gambar"
                                class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-indigo-500 bg-indigo-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                                <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/picture.png') . '" alt="gambar" loading="lazy" width="20" />
                                <p class="mt-1 text-xs">Gallery</p>
                            </a>
                            <a href="' . route('dashboard.product.edit', $item->id) . '" title="Edit"
                                class="flex flex-col shadow-sm  items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline">
                                <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="edit" loading="lazy" width="20" />
                                <p class="mt-1 text-xs">Edit</p>
                            </a>
                            <button type="button" title="Delete"
                                class="flex flex-col delete-button shadow-sm items-center justify-center w-20 h-12 border border-red-500 bg-red-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-red-500 focus:outline-none focus:shadow-outline"
                                data-id="' . $item->id . '">
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

    public function exportProducts(Request $request)
    {
        $products = Product::with('galleries')->with('category')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=products_' . date('d-m-Y') . '.csv',
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Name', 'Price', 'Description', 'Tags', 'Category ID', 'Category', 'Deleted At', 'Created At', 'Updated At', 'Image URL']);

            foreach ($products as $product) {
                $galleryUrls = '';
                // if ($product->galleries->count() > 0) {
                //     foreach ($product->galleries as $gallery) {
                //         // $galleryUrls .= Storage::url($gallery->url) . "\n";
                //         $galleryUrls .= $gallery->url.' || ';
                //     }
                // }
                if ($product->galleries->count() > 0) {
                    foreach ($product->galleries as $key => $gallery) {
                        $galleryUrls .= $gallery->url;
                        if ($key < $product->galleries->count() - 1) {
                            $galleryUrls .= ' || ';
                        }
                    }
                }
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->price,
                    $product->description,
                    $product->tags,
                    $product->categories_id,
                    $product->category->name,
                    $product->deleted_at,
                    $product->created_at,
                    $product->updated_at,
                    $galleryUrls,
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
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
    public function edit(Product $product)
    {
        $categories = ProductCategory::all();
        return view('pages.dashboard.product.edit', [
            'item' => $product,
            'categories' => $categories
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

        return redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('dashboard.product.index');
    }
}
