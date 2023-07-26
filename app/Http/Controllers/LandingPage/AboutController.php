<?php

namespace App\Http\Controllers\LandingPage;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LandingPage\LandingPageAbout;
use App\Models\LandingPage\LandingPageContact;
use App\Models\LandingPage\LandingPageAboutTeam;
use App\Models\LandingPage\LandingPageAboutFeature;

class AboutController extends Controller
{
    public function index()
    {
        $total_pending_count = 0;

        if (Auth::check()) {
            $user = Auth::user();

            if ($user->roles == "ADMIN") {
                $total_pending_count = Transaction::where('status', '=', 'PENDING')->count();
            } else {
                $total_pending_count = Transaction::where('status', '=', 'PENDING')->where('users_id', '=', $user->id)->count();
            }
        }

        $users_customer_count = User::where('roles', '=', 'USER')->count();
        $new_transaction = Transaction::count();
        $total_product = Product::count();
        $total_amount_success = Transaction::where('status', '=', 'SUCCESS')->sum('total_price');

        $landingPageAbout = LandingPageAbout::get();
        $landingPageAboutFeature = LandingPageAboutFeature::get();
        $landingPageAboutTeam = LandingPageAboutTeam::get();
        $landingPageContact = LandingPageContact::get();
        $products = Product::get();



        return view('landing_page.pages.about', [
            'total_pending_count' => $total_pending_count,
            'landingPageAbout' => $landingPageAbout,
            'landingPageAboutFeature' => $landingPageAboutFeature,
            'landingPageAboutTeam' => $landingPageAboutTeam,
            'users_customer_count' => $users_customer_count,
            'new_transaction' => $new_transaction,
            'total_product' => $total_product,
            'total_amount_success' => $total_amount_success,
            'landingPageContact' => $landingPageContact,
            'products' => $products,

        ]);
    }
}
