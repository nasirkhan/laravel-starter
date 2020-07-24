<?php

namespace App\Http\Controllers;

class LanguageController extends Controller
{
    public function switch($language)
    {
        app()->setLocale($language);

        session()->put('locale', $language);

        flash()->success(__("Language changed to") . " ". strtoupper($language))->important();

        return redirect()->back();
    }
}
