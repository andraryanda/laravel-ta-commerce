<?php

namespace App\Http\Controllers\Search;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LandingPage\LandingPageContact;

class PricingLandingPageSearchController extends Controller
{
    public function searchProductLandingPageCustomer(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where('name', 'like', '%' . $query . '%')->paginate(8);
        foreach ($products as $product) {
            $product->productGallery = ProductGallery::where('products_id', $product->id)->get();
        }
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->roles == "ADMIN") {
                $total_pending_count = Transaction::where('status', '=', 'PENDING')->count();
            } else {
                $total_pending_count = Transaction::where('status', '=', 'PENDING')->where('users_id', '=', $user->id)->count();
            }
        } else {
            $total_pending_count = 0;
        }

        $landingPageContact = LandingPageContact::get();

        return view('landing_page.pages.pricing', compact(
            'products',
            'total_pending_count',
            'landingPageContact',
        ));
    }
}
