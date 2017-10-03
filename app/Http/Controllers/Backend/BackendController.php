<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class BackendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "ok";
        return view('backend.dashboard');
    }
}
