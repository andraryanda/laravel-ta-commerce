<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HalamanUtamaController extends Controller
{
    public function index()
    {
        return view('landing_page.pages.index');
    }
}
