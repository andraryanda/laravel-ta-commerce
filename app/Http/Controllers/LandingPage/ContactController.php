<?php

namespace App\Http\Controllers\LandingPage;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
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
        return view('landing_page.pages.contact', [
            'total_pending_count' => $total_pending_count,
        ]);
    }
}
