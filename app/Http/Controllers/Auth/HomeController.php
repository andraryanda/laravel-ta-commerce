<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
       public function index()
       {
        $userRole = Auth::user()->roles;

        // Mengatur redirect home berdasarkan role pengguna
        if ($userRole == 'USER') {
            return redirect('/dashboardCustomer');
        } elseif ($userRole == 'ADMIN' || $userRole == 'OWNER') {
            return redirect('/dashboard');
        } else {
            return  redirect('/');
        }
       }
}
