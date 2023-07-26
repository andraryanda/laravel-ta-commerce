<?php

namespace App\Http\Controllers\LandingPage;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LandingPage\LandingPageContact;
use Illuminate\Pagination\LengthAwarePaginator;

class PricingController extends Controller
{

    public function index()
    {
        // Mengambil semua produk aktif
        $products = Product::where('status_product', 'ACTIVE')->paginate(4);

        foreach ($products as $product) {
            $product->productGallery = ProductGallery::where('products_id', $product->id)->get();
        }

        // Menghitung total jumlah pending transaction untuk menampilkan notifikasi pada navbar
        $total_pending_count = 0;

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->roles == "ADMIN") {
                $total_pending_count = Transaction::where('status', '=', 'PENDING')->count();
            } else {
                $total_pending_count = Transaction::where('status', '=', 'PENDING')->where('users_id', '=', $user->id)->count();
            }
        }

        $landingPageContact = LandingPageContact::get();


        return view('landing_page.pages.pricing', compact(
            'products',
            'total_pending_count',
            'landingPageContact'
        ));
    }



    // public function index()
    // {
    //     $products = Product::paginate(4);
    //     foreach ($products as $product) {
    //         // Menambahkan data ProductGallery ke setiap produk
    //         $product->productGallery = ProductGallery::where('products_id', $product->id)->get();
    //     }
    //     if (Auth::check()) {
    //         $user = Auth::user();
    //         if ($user->roles == "ADMIN") {
    //             $total_pending_count = Transaction::where('status', '=', 'PENDING')->count();
    //         } else {
    //             $total_pending_count = Transaction::where('status', '=', 'PENDING')->where('users_id', '=', $user->id)->count();
    //         }
    //     } else {
    //         $total_pending_count = 0;
    //     }

    //     return view('landing_page.pages.pricing', compact(
    //         'products',
    //         'total_pending_count',
    //     ));
    // }
}
