<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class landingPage extends Controller
{
    public function index()
    {
        return view('landingPage.index');
    }
}
