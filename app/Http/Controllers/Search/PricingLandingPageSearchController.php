<?php

namespace App\Http\Controllers\Search;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;

class PricingLandingPageSearchController extends Controller
{
    public function searchProductLandingPageCustomer(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('name', 'like', '%' . $query . '%')->paginate(8);
        foreach ($products as $product) {
            $product->productGallery = ProductGallery::where('products_id', $product->id)->get();
        }
        return view('landing_page.pages.pricing', compact('products'));
    }
}
