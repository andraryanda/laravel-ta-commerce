<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;

class PricingCustomerController extends Controller
{
    public function index()
    {
        $products = Product::get();
        foreach ($products as $product) {
            // Menambahkan data ProductGallery ke setiap produk
            $product->productGallery = ProductGallery::where('products_id', $product->id)->get();
        }

        return view('pages.customer.pricing.index', compact('products'));
    }
}
