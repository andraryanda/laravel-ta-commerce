<?php

namespace App\Http\Controllers\LandingPage;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;

class PricingController extends Controller
{
    public function index()
    {
        $products = Product::paginate(4);
        foreach ($products as $product) {
            // Menambahkan data ProductGallery ke setiap produk
            $product->productGallery = ProductGallery::where('products_id', $product->id)->get();
        }

        return view('landing_page.pages.pricing', compact('products'));
    }
}
