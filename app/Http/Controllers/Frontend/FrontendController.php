<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Notifications\NewRegistrationFromSocial;

class FrontendController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $body_class = '';
        $user = auth()->user() ;
        auth()->user()->notify(new NewRegistrationFromSocial($user));
        return view('frontend.index', compact('body_class'));
    }
}
