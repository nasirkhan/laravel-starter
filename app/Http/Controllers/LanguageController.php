<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function switch($language)
    {
        App::setLocale($language);

        session()->put('locale', $language);

        setlocale(LC_TIME, $language);

        Carbon::setLocale($language);

        flash()->success(__('Language changed to').' '.strtoupper($language))->important();

        return redirect()->back();
    }
}
