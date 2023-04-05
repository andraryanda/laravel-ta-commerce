<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HostingController extends Controller
{
    public function index()
    {
        return view('landing_page.pages.hosting');
    }
}
