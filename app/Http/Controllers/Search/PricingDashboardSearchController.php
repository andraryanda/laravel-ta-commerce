<?php

namespace App\Http\Controllers\Search;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;

class PricingDashboardSearchController extends Controller
{
    public function searchProductDashboardCustomer(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('name', 'like', '%' . $query . '%')->paginate(8);
        foreach ($products as $product) {
            $product->productGallery = ProductGallery::where('products_id', $product->id)->get();
        }
        return view('pages.customer.pricing.index', compact('products'));
    }
}
