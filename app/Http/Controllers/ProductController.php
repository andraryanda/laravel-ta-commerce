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
                        <a class="inline-block border border-purple-700 bg-purple-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-purple-800 focus:outline-none focus:shadow-outline"
                            href="' . route('dashboard.product.gallery.index', $item->id) . '">
                            <i class="fa fa-image"></i> Gambar
                        </a>
                        <a class="inline-block border border-yellow-500 bg-yellow-400 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                            href="' . route('dashboard.product.edit', $item->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <form class="inline-block" action="' . route('dashboard.product.destroy', $item->id) . '" method="POST">
                        <button title="Hapus" class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                        <i class="fa fa-trash"></i> Hapus
                        </button>
                            ' . method_field('delete') . csrf_field() . '
                        </form>';
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
    $products = Product::with('galleries')->get();

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename=products_' . date('d-m-Y') . '.csv',
    ];

    $callback = function () use ($products) {
        $file = fopen('php://output', 'w');

        fputcsv($file, ['ID', 'Name', 'Price', 'Description', 'Tags', 'Category ID', 'Deleted At', 'Created At', 'Updated At', 'Image URL']);

        foreach ($products as $product) {
            $galleryUrls = '';
            if ($product->galleries->count() > 0) {
                foreach ($product->galleries as $gallery) {
                    // $galleryUrls .= Storage::url($gallery->url) . "\n";
                    $galleryUrls .= $gallery->url;
                }
            }
            fputcsv($file, [
                $product->id,
                $product->name,
                $product->price,
                $product->description,
                $product->tags,
                $product->categories_id,
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
        return view('pages.dashboard.product.edit',[
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
